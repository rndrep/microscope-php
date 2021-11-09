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
    public function index()
    {
        //TODO: add sorting
        $minerals = Mineral::all();
        return view('admin.minerals.index', ['minerals' => $minerals, 'fields' => Mineral::SIMPLE_INPUT_FIELDS]);
    }

    public function create()
    {
        return view('admin.minerals.create', ['fields' => Mineral::SIMPLE_INPUT_FIELDS]);
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

        return redirect()->route('minerals.index');
    }

    public function edit($id)
    {
        $item = Mineral::find($id);
        return view('admin.minerals.edit', ['item' => $item, 'fields' => Mineral::SIMPLE_INPUT_FIELDS]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        $item = Mineral::find($id);
        $item->update($request->all());
        $item->uploadMicroscope(
            $request->file('pplPhotos') ?? [],
            $request->file('xplPhotos') ?? []
        );
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

}
