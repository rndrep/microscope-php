<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testFullName()
    {
        $user = new User();
        $user->last_name = 'Иванов';
        $user->first_name = 'Иван';
        $user->patronymic = 'Иванович';

        $this->assertEquals('Иванов Иван Иванович', $user->getFullName());
        $this->assertNotEquals('Иван Иванович', $user->getFullName());
    }

    public function testRole()
    {
       $roles = [
            1 => 'Администратор',
            2 => 'Студент'
        ];
        $user = new User();
        $user->setRoleId(1);
        $this->assertEquals($roles[1], $user->getRoleName());
        $this->assertTrue($user->isAdmin());
        $user->setRoleId(2);
        $this->assertEquals($roles[2], $user->getRoleName());
        $this->assertTrue($user->isUser());
    }

    public function testPassword()
    {
        $pwd = 'test';
        $user = new User();
        $user->setPassword($pwd);
        self::assertNotEquals($pwd, $user->password);
        self::assertNotEquals(Hash::make($pwd), $user->password);
    }

//    public function testAuth()
//    {
//        $email = 'test@test.com';
//        $pwd = 'test';
//        $user = new User();
//        $user->last_name = 'Иванов';
//        $user->first_name = 'Иван';
//        $user->email = $email;
//        $user->setPassword($pwd);
//        $user->save();
//
//        $this->assertFalse(Auth::check());
//        $this->assertTrue(Auth::attempt(['email' => $email, 'password' => $pwd]));
//        $this->assertTrue(Auth::check());
//        Auth::logout();
//        $this->assertFalse(Auth::check());
//
//        if ($user) {
//            $user->delete();
//        }
//    }
}
