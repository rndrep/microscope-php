<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractMediaEntity;
use App\Models\Fossil;
use App\Models\Rock_FormingMineral;
use App\Models\RockClass;
use App\Models\Mineral;
use App\Models\Rock;
use App\Models\RockFamily;
use App\Models\RockKind;
use App\Models\RockSquad;
use App\Models\RockStructure;
use App\Models\RockTexture;
use App\Models\RockType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RockController extends Controller
{
    const ITEMS_PER_PAGE = 6;
    const SEARCH_FIELDS = [
        'rockName' => ['prop' => 'name', 'strict' => false],
        'rockType' => ['prop' => 'rock_type_id', 'strict' => true],
        'rockClass' => ['prop' => 'rock_class_id', 'strict' => true],
        'rockKind' => ['prop' => 'rock_kind_id', 'strict' => true],
        'rockFormingMinerals' => ['prop' => 'forming_mineral_id', 'strict' => true],
    ];

    /**
     * Get items for search page
     */
    public function list(Request $request)
    {
        $params = $request->all();
        $params = array_intersect_key($params, self::SEARCH_FIELDS);
        $query = Rock::query();

        foreach ($params as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if ($key == 'rockFormingMinerals') {
                $rockIdByFormingMineral = Rock_FormingMineral::select('rock_id')
                    ->where('mineral_id', $value)
                    ->pluck('rock_id')
                    ->toArray();
                $query->whereIn('id', $rockIdByFormingMineral);
                continue;
            }
            if (self::SEARCH_FIELDS[$key]['strict']) {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], $value);
            } else {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], 'ILIKE', '%' . $value . '%');
            }
        }

        if (!Auth::check()) {
            $query->where('is_public', 1);
        }
        $result = $query->orderBy('name')->paginate(self::ITEMS_PER_PAGE);
//        $result = $query->orderBy('name')->get();
        $result->map(function ($item) {
            $item->photo = $item->getPhoto();
            $item->microscope_url = Rock::getMicroscopeUrl($item->id);
            $item->info_url = route('rock_info', $item->id);
            return $item;
        });
//        return ['data' => $result];
        return $result;
    }

    //TODO: delete (moved in PageController)
//    public function home()
//    {
//        phpinfo();
//        dump(Auth::check());
//        dump(Auth::user());
//        if (Auth::check() && Auth::user()->isUser()) {
//            return view('dist.index', ['items' => Rock::orderBy('name')->paginate(self::ITEMS_PER_PAGE)]);
//        }
//        return view('dist.index', ['items' => Rock::where('is_public', 1)->orderBy('name')->paginate(self::ITEMS_PER_PAGE)]);
//    }

    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->isContentManager()) {
                return view('admin.rocks.index', ['items' => Rock::orderBy('id')->get()]);
                //return view('admin.rocks.index', ['items' => Rock::orderBy('name')->paginate(self::ITEMS_PER_PAGE)]);
            }
            if (Auth::user()->isUser()) {
//                return view('dist.index', ['items' => Rock::orderBy('name')->paginate(self::ITEMS_PER_PAGE)]);
                return view('dist.index', ['items' => Rock::orderBy('name')->get()]);
            }
        }
//        return view('dist.index', ['items' => Rock::where('is_public', 1)->orderBy('name')->paginate(self::ITEMS_PER_PAGE)]);
        return view('dist.index', ['items' => Rock::where('is_public', 1)->orderBy('name')->get()]);
    }

    public function create()
    {
        return view(
            'admin.rocks.create',
            [
                'rockTypes' => RockType::orderBy('name')->pluck('name', 'id'),
                'minerals' => Mineral::orderBy('name')->pluck('name', 'id'),
                'fossils' => Fossil::orderBy('name')->pluck('name', 'id'),
                'rockClasses' => RockClass::orderBy('name')->pluck('name', 'id'),
                'rockSquads' => RockSquad::orderBy('name')->pluck('name', 'id'),
                'rockFamilies' => RockFamily::orderBy('name')->pluck('name', 'id'),
                'rockKinds' => RockKind::orderBy('name')->pluck('name', 'id'),
                'rockTextures' => RockTexture::orderBy('name')->pluck('name', 'id'),
                'rockStructures' => RockStructure::orderBy('name')->pluck('name', 'id'),
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>'required|max:255',
        ]);
        $item = Rock::add($request->all());
        $item->setRockType($request->get('rock_type_id'));
        $item->setRockClass($request->get('rock_class_id'));
        $item->setRockSquad($request->get('rock_squad_id'));
        $item->setRockFamily($request->get('rock_family_id'));
        $item->setRockKind($request->get('rock_kind_id'));
        $item->setRockTexture($request->get('rock_texture_id'));
        $item->setRockStructure($request->get('rock_structure_id'));
        $item->setFormingMinerals($request->get('forming_minerals'));
        $item->setSecondMinerals($request->get('second_minerals'));
        $item->setAccessoryMinerals($request->get('accessory_minerals'));
        $item->setFossils($request->get('fossils'));
        $item->toggleStatus($request->get('is_public'));
        $item->save();
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
        $selectedFossils = $rock->fossils->pluck('id')->all();

        return view(
            'admin.rocks.edit',
            [
                'item' => $rock,
                'rockTypes' => RockType::orderBy('name')->pluck('name', 'id'),
                'minerals' => Mineral::orderBy('name')->pluck('name', 'id'),
                'fossils' => Fossil::orderBy('name')->pluck('name', 'id'),
                'rockClasses' => RockClass::orderBy('name')->pluck('name', 'id'),
                'rockSquads' => RockSquad::orderBy('name')->pluck('name', 'id'),
                'rockFamilies' => RockFamily::orderBy('name')->pluck('name', 'id'),
                'rockKinds' => RockKind::orderBy('name')->pluck('name', 'id'),
                'rockTextures' => RockTexture::orderBy('name')->pluck('name', 'id'),
                'rockStructures' => RockStructure::orderBy('name')->pluck('name', 'id'),
                'selectedFormMinerals' => $selectedFormMinerals,
                'selectedSecMinerals' => $selectedSecMinerals,
                'selectedAcMinerals' => $selectedAcMinerals,
                'selectedFossils' => $selectedFossils
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);

        /** @var Rock $item */
        $item = Rock::find($id);
        $item->edit($request->all());
        $item->setRockType($request->get('rock_type_id'));
        $item->setRockClass($request->get('rock_class_id'));
        $item->setRockSquad($request->get('rock_squad_id'));
        $item->setRockFamily($request->get('rock_family_id'));
        $item->setRockKind($request->get('rock_kind_id'));
        $item->setRockTexture($request->get('rock_texture_id'));
        $item->setRockStructure($request->get('rock_structure_id'));
        $item->setFormingMinerals($request->get('forming_minerals'));
        $item->setSecondMinerals($request->get('second_minerals'));
        $item->setAccessoryMinerals($request->get('accessory_minerals'));
        $item->setFossils($request->get('fossils'));
        $item->toggleStatus($request->get('is_public'));
        $item->save();
        return redirect()->route('rocks.index');
    }

    public function destroy($id)
    {
        Rock::find($id)->remove();
        return redirect()->route('rocks.index');
    }

    public function getMicroPhotosJson($id): string
    {
        if (empty($id)) {
            return json_encode([]);
        }
        $publicPath = Rock::MICRO_PATH . $id . '/';
        $photos = [
            'ppl' => AbstractMediaEntity::getPhotoUrls($publicPath . 'ppl'),
            'xpl' => AbstractMediaEntity::getPhotoUrls($publicPath . 'xpl'),
            'smooth' => true,
            'shift' => 5,
        ];
        return json_encode($photos);
    }

    /**
     * get item detail page for user
     *
     * @param $id
     * @return false|Application|Factory|View
     */
    public function info($id)
    {
        if (empty($id)) {
            return false;
        }
        /** @var Rock $rock */
        $rock = Rock::find($id);

        if (empty($rock)) {
            return false;
        }

        if (!Auth::check() && !$rock->isPublic()) {
            abort(404);
        }
        $microRoute = Rock::getMicroscopeUrl($id);
        return view(
            'dist.rock',
            [
                'item' => $rock,
//TODO: Rock::getInfoFields()
//                'fields' => $item->getInfoFields(),
                'microscopeRoute' => $microRoute,
                'rotationRoute' => Rock::getRotationUrl($id),
                'gallery' => $rock::getPhotoUrls(Rock::GALLERY_PATH . $rock->id),
            ]
        );
    }
}
