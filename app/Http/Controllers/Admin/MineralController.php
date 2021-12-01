<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractMediaEntity;
use App\Models\Mineral;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
use App\Models\Rock_AccessoryMineral;
use App\Models\Rock_FormingMineral;
use App\Models\Rock_SecondMineral;
use Illuminate\Http\Request;

class MineralController extends Controller
{

    //TODO: move ITEMS_PER_PAGE into some common place?
    const ITEMS_PER_PAGE = 12;
    const SEARCH_FIELDS = [
        'mineralName' => 'name',
        'mineralClass' => 'class',
        'mineralCrystalForm' => 'crystal_form',
        'mineralShine' => 'shine',
        'mineralSplitting' => 'splitting_id',
    ];

    /**
     * Get items for search page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list(Request $request)
    {
        $params = $request->json()->all();
        $params = array_intersect_key($params, self::SEARCH_FIELDS);
        $query = Mineral::query();
        foreach ($params as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $query->where(self::SEARCH_FIELDS[$key], $value);
        }
        $result = $query->orderBy('name')->paginate(self::ITEMS_PER_PAGE);
        $result->map(function ($item) {
            $item->microscope_url = Mineral::getMicroscopeUrl($item->id);
            $item->info_url = route('mineral_info', $item->id);
            return $item;
        });
        return $result;
    }

    public function index()
    {
        $items = Mineral::orderBy('name')->get();
        return view('admin.minerals.index', [
            'items' => $items,
            'fields' => Mineral::getInputs()]);
    }

    public function create()
    {
        return view(
            'admin.minerals.create',
            [
                'fields' => Mineral::getInputs(),
                'syngonyItems' => MineralSyngony::orderBy('name')->pluck('name', 'id'),
                'splittingItems' => MineralSplitting::orderBy('name')->pluck('name', 'id'),
            ]
        );
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
        return view(
            'admin.minerals.edit',
            [
                'item' => $item,
                'fields' => Mineral::getInputs(),
                'syngonyItems' => MineralSyngony::orderBy('name')->pluck('name', 'id'),
                'splittingItems' => MineralSplitting::orderBy('name')->pluck('name', 'id'),
            ]
        );
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
        if (empty($id)) {
            return false;
        }
        /** @var Mineral $item */
        $item = Mineral::find($id);

        if (empty($item)) {
            return false;
        }
        $microRoute = is_dir(public_path(AbstractMediaEntity::IMAGE_PATH_MINERAL_MICRO . $id . '/ppl'))
            ? route('microscope', ['id' => $id, 'type' => 'mineral'])
            : '';
        return view('dist.mineral', ['item' => $item, 'fields' => $item->getInfoFields(), 'microscopeRoute' => $microRoute]);
    }

}
