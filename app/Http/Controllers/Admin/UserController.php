<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $items = User::all();
        return view('admin.users.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.users.create', ['roleIds' => User::ROLE_NAMES]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'	=>	'required',
            'email'         =>	'required|email',
            'role_id'       =>  'required',
        ]);
        /** @var User $user */
        $user = User::add($request->all());
        $user->setPassword($request->get('password'));
        $user->setRoleId($request->get('role_id'));
        $user->save();

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $item = User::find($id);
        return view('admin.users.edit', ['item' => $item, 'roleIds' => User::ROLE_NAMES]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'	=>	'required',
            'email'         =>	'required|email',
            'role_id'       =>  'required',
        ]);
        /** @var User $item */
        $item = User::find($id);
        $item->edit($request->all());
        $item->setPassword($request->get('password'));
        $item->setRoleId($request->get('role_id'));
        $item->save();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $item = User::find($id);
        $item->remove();
        return redirect()->route('users.index');
    }
}
