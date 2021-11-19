<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {

    }

    public function register(Request  $request)
    {

    }

    public function loginForm()
    {
        return view('main.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->isContentManager()) {
                //TODO: check why don't redirect
                return redirect()->route('rocks.index');
            }
            return redirect()->intended();
        }
        return back()->withErrors([
            'login' => 'почта и/или пароль неверны'
        ]);
    }

    public function logout()
    {
        $isSSOUser = Auth::user()->isSSO();
        Auth::logout();
        if ($isSSOUser) {
            return redirect(
                'http://aid.main.tpu.ru:7777/pls/orasso/orasso.wwsso_app_admin.ls_logout?p_done_url=' .
                route('home')
            );
        }
        return redirect('/login');
    }

    public function loginTpu(Request $request)
    {
        // doesn't work by curl
        $url = sprintf(
            'http://portal.tpu.ru/ssogate/redirect?p_lsnrtoken=vmicro.tpu.ru&p_cancel=%s&p_forcedauth=false',
            route('login_form')
        );
//        $ch = curl_init();
////        $url = 'www.google.com';
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
////        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//        $output = curl_exec($ch);
//        curl_close($ch);
//        var_dump($output);
        return redirect($url);
    }

    public function ssoAuth(Request $request)
    {
        //TODO: try this to auth without db
        // https://newbedev.com/lumen-http-basic-authentication-without-use-of-database

        $url = 'http://portal.tpu.ru/ssogate/info?p_lsnrtoken=vmicro.tpu.ru&p_urlc=' . $request->get('urlc');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        try {
            $user = $this->parseXml2User($response);
        } catch (\Exception $e) {
            //TODO: show error
            $e->getMessage();
        }
//        dump($user);
//        die;

        if (empty($user) || empty($user->getEmail())) {
            return redirect('/login');
        }
        $dbUSer = User::where('email', $user->getEmail())
            ->where('is_sso', 1)
            ->first();

        if (empty($dbUSer)) {
            $user->save();
        } else {
            $user = $dbUSer;
        }

        //юзер, которого нет в базе не будет авторизован после редиректа. Мб что-то можно сделать с сессией
        Auth::login($user);
//        dump(Auth::check());
//        dump(Auth::user());
//        die;
//        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function ssoLogout(Request $request)
    {
        //What user should be logout?
//        Auth::logout();
        return  env('APP_URL') . '/img/sso/ok.gif';
    }

    /**
     * @throws \Exception
     */
    private function parseXml2User(string $xml): User
    {
        $xmlParser = xml_parser_create();
        if (0 == xml_parse_into_struct($xmlParser, $xml, $values, $indexes)) {
            xml_parser_free($xmlParser);
            throw new \Exception('XML response parsing error');
        }

        $index2UserField = [
            'USER_NAME' => 'Login',
            'IMYA' => 'FirstName',
            'FAM' => 'LastName',
            'OTCHESTVO' => 'Patronymic',
            'EMAIL' => 'Email',
        ];

//        dump($values);
//        dump($indexes);

        $errors = [];
        $user = new User();
        foreach ($index2UserField as $key => $fieldName) {
            $fieldValueIndex = $indexes[$key];
            if (!is_array($fieldValueIndex) || count($fieldValueIndex) != 1) {
                $errors[] = sprintf(
                    'XML field parsing error. key: %s, value: %s',
                    $key, var_export($fieldValueIndex, true)
                );
                continue;
            }
            $fieldValue = $values[$fieldValueIndex[0]]['value'];

            //TODO: validate fields
            call_user_func([$user, 'set' . $fieldName], $fieldValue);
        }
        if (!empty($errors)) {
            throw new \Exception(implode("\n", $errors));
        }
        xml_parser_free($xmlParser);

        //TODO: set role for tpu user
        $user->setPassword(bin2hex(random_bytes(4)))
            ->setRoleId(User::ROLE_USER)
            ->setSSO(1);
        return $user;
    }

}
