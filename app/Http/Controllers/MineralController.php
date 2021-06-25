<?php

namespace App\Http\Controllers;

use App\Models\Mineral;
use App\Models\Rock_AccessoryMineral;
use App\Models\Rock_FormingMineral;
use App\Models\Rock_SecondMineral;
use Illuminate\Http\Request;

class MineralController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $minerals = Mineral::all();
        return view('admin.minerals.index', ['minerals' => $minerals]);
    }

    public function create()
    {
        return view('admin.minerals.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        Mineral::create($request->all());
        return redirect()->route('minerals.index');
    }

    public function edit($id)
    {
        $item = Mineral::find($id);
        return view('admin.minerals.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        $item = Mineral::find($id);
        $item->update($request->all());
        return redirect()->route('minerals.index');
    }

    public function destroy($id)
    {
        if (Rock_FormingMineral::firstWhere('mineral_id', $id)
            || Rock_SecondMineral::firstWhere('mineral_id', $id)
            || Rock_AccessoryMineral::firstWhere('mineral_id', $id)
        ) {
            //TODO: add custom error in template
            return 'Нельзя удалить минерал. Существует порода с данным минералом.'; // don't delete if there is rock with this rock type
        }
        Mineral::find($id)->delete();
        return redirect()->route('minerals.index');
    }
}
