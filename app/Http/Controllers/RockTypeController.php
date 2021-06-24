<?php

namespace App\Http\Controllers;

use App\Models\Rock;
use App\Models\RockType;
use Illuminate\Http\Request;


class RockTypeController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $rockTypes = RockType::all();
        return view('admin.rock-types.index', ['rockTypes' => $rockTypes]);
    }

    public function create()
    {
        return view('admin.rock-types.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        RockType::create($request->all());
        return redirect()->route('rock-types.index');
    }

    public function edit($id)
    {
        $item = RockType::find($id);
        return view('admin.rock-types.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        $item = RockType::find($id);
        $item->update($request->all());
        return redirect()->route('rock-types.index');
    }

    public function destroy($id)
    {
        if (Rock::firstWhere('rock_types_id', $id)) {
            //TODO: add custom error in template
            return 'Нельзя удалить тип породы. Существует порода с данным типом.'; // don't delete if there is rock with this rock type
        }
        RockType::find($id)->delete();
        return redirect()->route('rock-types.index');
    }
}
