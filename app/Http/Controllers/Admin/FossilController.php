<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fossil;
use App\Models\Rock_Fossil;
use Illuminate\Http\Request;

class FossilController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $items = Fossil::all();
        return view('admin.fossils.index', ['items' => $items, 'fields' => Fossil::SIMPLE_INPUT_FIELDS]);
    }

    public function create()
    {
        return view('admin.fossils.create', ['fields' => Fossil::SIMPLE_INPUT_FIELDS]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required'
        ]);

        $item = Fossil::add($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->uploadMicroscope(
            $request->file('pplPhotos') ?? [],
            $request->file('xplPhotos') ?? []
        );
        $item->save();
        return redirect()->route('fossils.index');
    }

    public function edit($id)
    {
        return view('admin.fossils.edit', ['item' => Fossil::find($id), 'fields' => Fossil::SIMPLE_INPUT_FIELDS]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required'
        ]);
        /** @var Fossil $item */
        $item = Fossil::find($id);
        $item->update($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->save();
        return redirect()->route('fossils.index');
    }

    public function destroy($id)
    {
        //Maybe allow to remove? Just also remove record in rock__fossils table.
        if (Rock_Fossil::firstWhere('fossil_id', $id)) {
            return 'Нельзя удалить окаменелость. Существует порода с данной окаменелостью.';
        }
        Fossil::find($id)->remove();
        return redirect()->route('fossils.index');
    }

    public function getMicroPhotosJson($id)
    {
        //no microscope
    }

    public function info()
    {
        //TODO
    }

}
