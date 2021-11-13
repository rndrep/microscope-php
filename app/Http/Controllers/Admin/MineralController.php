<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractMediaEntity;
use App\Models\Mineral;
use App\Models\Rock_AccessoryMineral;
use App\Models\Rock_FormingMineral;
use App\Models\Rock_SecondMineral;
use Illuminate\Http\Request;

class MineralController extends Controller
{

    //TODO: replace Mineral templates by common
    //TODO: remove old Mineral templates
    public function index()
    {
        $items = Mineral::orderBy('name')->get();
        return view('admin.entity.index', [
            'entityCaption' => Mineral::ENTITY_CAPTION,
            'entityName' => Mineral::ENTITY_NAME,
            'items' => $items,
            'fields' => Mineral::getInputs()]);
    }

    public function create()
    {
        return view('admin.minerals.create', ['fields' => Mineral::getInputs()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);

        /** @var Mineral $item */
        $item = Mineral::add($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->uploadMicroscope(
            $request->file('pplPhotos') ?? [],
            $request->file('xplPhotos') ?? []
        );
        $item->save();
        return redirect()->route('minerals.index');
    }

    public function edit($id)
    {
        $item = Mineral::find($id);
        return view('admin.minerals.edit', ['item' => $item, 'fields' => Mineral::getInputs()]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        /** @var Mineral $item */
        $item = Mineral::find($id);
        $item->update($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->uploadMicroscope(
            $request->file('pplPhotos') ?? [],
            $request->file('xplPhotos') ?? []
        );
        $item->save();

        return redirect()->route('minerals.index');
    }

    public function destroy($id)
    {
        // don't delete if there is rock with this mineral
        if (Rock_FormingMineral::firstWhere('mineral_id', $id)
            || Rock_SecondMineral::firstWhere('mineral_id', $id)
            || Rock_AccessoryMineral::firstWhere('mineral_id', $id)
        ) {
            //TODO: add custom error in template
            return 'Нельзя удалить минерал. Существует порода с данным минералом.';
        }
        Mineral::find($id)->remove();
        return redirect()->route('minerals.index');
    }

    public function getMicroPhotosJson($id): string
    {
        if (empty($id)) {
            return json_encode([]);
        }
        $publicPath = AbstractMediaEntity::IMAGE_PATH_MINERAL_MICRO . $id . '/';
        $photos = [
            'ppl' => AbstractMediaEntity::getMicroPhotoPaths($publicPath . 'ppl'),
            'xpl' => AbstractMediaEntity::getMicroPhotoPaths($publicPath . 'xpl'),
            'smooth' => false,
            'shift' => 10,
        ];
        return json_encode($photos);
    }

    public function info($id)
    {
        //TODO
    }

}
