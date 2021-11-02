<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rock;
use App\Models\RockClass;
use Illuminate\Http\Request;

class RockClassController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $items = RockClass::all();
        return view('admin.rock-classes.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.rock-classes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        RockClass::create($request->all());
        return redirect()->route('rock-classes.index');
    }

    public function edit($id)
    {
        $item = RockClass::find($id);
        return view('admin.rock-classes.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        $item = RockClass::find($id);
        $item->update($request->all());
        return redirect()->route('rock-classes.index');
    }

    public function destroy($id)
    {
        if (Rock::firstWhere('rock_class_id', $id)) {
            //TODO: add custom error in template
            return 'Нельзя удалить класс. Существует порода с данным классом.';
        }
        RockClass::find($id)->delete();
        return redirect()->route('rock-classes.index');
    }
}
