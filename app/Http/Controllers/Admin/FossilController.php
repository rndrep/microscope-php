<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fossil;
use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Rock_Fossil;
use Illuminate\Http\Request;

class FossilController extends Controller
{
    //TODO: replace fossils templates by common
    //TODO: remove old fossils templates
    public function index()
    {
        $items = Fossil::orderBy('name')->get();
        return view('admin.fossils.index', [
//            'entityCaption' => Fossil::ENTITY_CAPTION,
//            'entityName' => Fossil::ENTITY_NAME,
            'items' => $items,
            'fields' => Fossil::getInputs()]);
    }

    public function create()
    {
        return view(
            'admin.fossils.create',
            [
                'fields' => Fossil::getInputs(),
                'invertebrates' => Invertebrate::orderBy('name')->pluck('name', 'id'),
                'indexFossils' => IndexFossil::orderBy('name')->pluck('name', 'id'),
            ]
        );
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
        return view(
            'admin.fossils.edit',
            [
                'item' => Fossil::find($id),
                'fields' => Fossil::getInputs(),
                'invertebrates' => Invertebrate::orderBy('name')->pluck('name', 'id'),
                'indexFossils' => IndexFossil::orderBy('name')->pluck('name', 'id')
            ]
        );
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

    public function info($id)
    {
        if (empty($id)) {
            return false;
        }
        /** @var Fossil $item */
        $item = Fossil::find($id);
        if (empty($item)) {
            return false;
        }
        return view('dist.mineral', ['item' => $item, 'fields' => $item->getInfoFields()]);
    }

}
