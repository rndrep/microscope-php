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
use Illuminate\Support\Facades\Auth;

class MineralController extends Controller
{

    //TODO: move ITEMS_PER_PAGE into some common place?
    const ITEMS_PER_PAGE = 12;
    const SEARCH_FIELDS = [
        'mineralName' => ['prop' => 'name', 'strict' => false],
        'mineralClass' => ['prop' => 'class', 'strict' => false],
        'mineralCrystalForm' => ['prop' => 'crystal_form', 'strict' => false],
        'mineralShine' => ['prop' => 'shine', 'strict' => false],
        'mineralSplitting' => ['prop' => 'splitting_id', 'strict' => true],
    ];

    const VALIDATE_RULES = [
        'name' => 'required',
        'hardness' => 'nullable|integer|min:0|max:10', //|regex:/^\d{1,2}$/
    ];

    /**
     * Get items for search page
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
            if (self::SEARCH_FIELDS[$key]['strict']) {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], $value);
            } else {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], 'LIKE', '%' . $value . '%');
            }
        }
        if (!Auth::check()) {
            $query->where('is_public', 1);
        }
        $result = $query->orderBy('name')->paginate(self::ITEMS_PER_PAGE);
//        $result = $query->orderBy('name')->get();
        $result->map(function ($item) {
            $item->photo = $item->getPhoto();
            $item->microscope_url = Mineral::getMicroscopeUrl($item->id);
            $item->info_url = route('mineral_info', $item->id);
            return $item;
        });
//        return ['data' => $result];
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
        $this->validate($request, self::VALIDATE_RULES);

        /** @var Mineral $item */
        $item = Mineral::add($request->all());
        $item->toggleStatus($request->get('is_public'));
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
                'fields' => Mineral::getInputs($item),
                'syngonyItems' => MineralSyngony::orderBy('name')->pluck('name', 'id'),
                'splittingItems' => MineralSplitting::orderBy('name')->pluck('name', 'id'),
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, self::VALIDATE_RULES);

        /** @var Mineral $item */
        $item = Mineral::find($id);
        $item->toggleStatus($request->get('is_public'));
        $item->update($request->all());
//        $item->save();

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
        $publicPath = Mineral::MICRO_PATH . $id . '/';
        $photos = [
            'ppl' => AbstractMediaEntity::getPhotoUrls($publicPath . 'ppl'),
            'xpl' => AbstractMediaEntity::getPhotoUrls($publicPath . 'xpl'),
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

        return view('dist.mineral',
            [
                'item' => $item,
                'fields' => $item->getInfoFields(),
                'microscopeRoute' => Mineral::getMicroscopeUrl($id),
                'rotationRoute' => Mineral::getRotationUrl($id),
                'gallery' => $item::getPhotoUrls(Mineral::GALLERY_PATH . $item->id),
            ]
        );
    }

}
