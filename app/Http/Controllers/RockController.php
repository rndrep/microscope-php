<?php

namespace App\Http\Controllers;

use App\Models\Mineral;
use App\Models\Rock;
use App\Models\RockType;
use Illuminate\Http\Request;

class RockController extends Controller
{
    public function index()
    {
        return view('admin.rocks.index', ['rocks' => Rock::all()]);
    }

    public function create()
    {
        return view(
            'admin.rocks.create',
            [
                'rockTypes' => RockType::pluck('name', 'id'),
                'minerals' => Mineral::pluck('name', 'id')
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
            'photo' => 'nullable|image'
        ]);
        $rock = Rock::add($request->all());
        $rock->uploadImage($request->file('photo'));
        $rock->setRockType($request->get('rock_type_id'));
        $rock->setFormingMinerals($request->get('forming_minerals'));
        $rock->setSecondMinerals($request->get('second_minerals'));
        $rock->setAccessoryMinerals($request->get('accessory_minerals'));
        return redirect()->route('rocks.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return false;
        }

        $rock = Rock::find($id);

        if (empty($rock)) {
            return false;
        }

        $selectedFormMinerals = $rock->formingMinerals->pluck('id')->all();
        $selectedSecMinerals = $rock->secondMinerals->pluck('id')->all();
        $selectedAcMinerals = $rock->accessoryMinerals->pluck('id')->all();

        return view(
            'admin.rocks.edit',
            [
                'rock' => $rock,
                'rockTypes' => RockType::pluck('name', 'id'),
                'minerals' => Mineral::pluck('name', 'id'),
                'selectedFormMinerals' => $selectedFormMinerals,
                'selectedSecMinerals' => $selectedSecMinerals,
                'selectedAcMinerals' => $selectedAcMinerals
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'photo' => 'nullable|image'
        ]);
        $rock = Rock::find($id);
        $rock->edit($request->all());
        $rock->uploadImage($request->file('photo'));
        $rock->setRockType($request->get('rock_type_id'));
        $rock->setFormingMinerals($request->get('forming_minerals'));
        $rock->setSecondMinerals($request->get('second_minerals'));
        $rock->setAccessoryMinerals($request->get('accessory_minerals'));
        return redirect()->route('rocks.index');
    }

    public function destroy($id)
    {
        $rock = Rock::find($id)->remove();
    }

}
