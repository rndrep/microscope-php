<?php

namespace App\Http\Controllers;

use App\Models\AbstractMediaEntity;
use App\Models\Fossil;
use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Mineral;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
use App\Models\MineralClass;
use App\Models\MineralCrystalForm;
use App\Models\MineralShine;
use App\Models\Rock;
use App\Models\RockClass;
use App\Models\RockKind;
use App\Models\RockType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function home()
    {
        return view(
            'dist.index',
            array_merge($this->rockSelectFields(), $this->mineralSelectFields(), $this->fossilSelectFields())
        );
    }

    public function notfound()
    {
        return view('dist.404');
    }

    public function microscope(Request $request)
    {
        [$routeName, $entity] = $this->getBreadcumbsParams($request);
        return view('dist/microscope', [
            'routeName' => $routeName,
            'itemId' => $entity->id ?? '',
            'itemName' => $entity->name ?? '',
        ]);
    }

    public function rotation(Request $request)
    {
        $src = $request->query('src');
        [$routeName, $entity] = $this->getBreadcumbsParams($request);
        $item = new \stdClass();
        $item->id = $entity->id ?? '';
        $item->name = $entity->name ?? '';
        return view(
            'dist/rotation',
            [
                'src' => $src,
                'routeName' => $routeName,
                'item' => $item
            ]
        );
    }

    public function map()
    {
        return view('dist/map');
    }

    /**
     * Get all items to display on the map
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapItems()
    {
        $isAuth = Auth::check();

        $items = $isAuth
            ? Rock::all()
            : Rock::where('is_public', 1)->get();
        $result = $items->map(function (AbstractMediaEntity $item) {
                $tmpObj = new \stdClass();
                $tmpObj->type = 'Порода';
                $tmpObj->name = $item->name;
                $tmpObj->url = route('rock_info', $item->id);
                $tmpObj->lat = $item->x;
                $tmpObj->lng = $item->y;
                return $tmpObj;
            }
        )->toArray();

        $items = $isAuth
            ? Mineral::all()
            : Mineral::where('is_public', 1)->get();
        $result = array_merge(
            $result,
            $items->map(function (AbstractMediaEntity $item) {
                $tmpObj = new \stdClass();
                $tmpObj->type = 'Минерал';
                $tmpObj->name = $item->name;
                $tmpObj->url = route('mineral_info', $item->id);
                $tmpObj->lat = $item->x;
                $tmpObj->lng = $item->y;
                return $tmpObj;
            })->toArray()
        );

        $items = $isAuth
            ? Fossil::all()
            : Fossil::where('is_public', 1)->get();
        $result = array_merge(
            $result,
            $items->map(function (AbstractMediaEntity $item) {
                $tmpObj = new \stdClass();
                $tmpObj->type = 'Окаменелость';
                $tmpObj->name = $item->name;
                $tmpObj->url = route('fossil_info', $item->id);
                $tmpObj->lat = $item->x;
                $tmpObj->lng = $item->y;
                return $tmpObj;
            })->toArray()
        );
        return response()->json($result);
    }

    private function rockSelectFields()
    {
        return [
            'rockTypes' => RockType::orderBy('name')->pluck('name', 'id'),
            'rockClasses' => RockClass::orderBy('name')->pluck('name', 'id'),
            'minerals' => Mineral::orderBy('name')->pluck('name', 'id'),
            'rockKinds' => RockKind::orderBy('name')->pluck('name', 'id'),
         ];
    }

    private function mineralSelectFields()
    {
        return [
            'syngony' => MineralSyngony::orderBy('name')->pluck('name', 'id'),
            'splitting' => MineralSplitting::orderBy('name')->pluck('name', 'id'),
            'mineralClass' => MineralClass::orderBy('name')->pluck('name', 'id'),
            'mineralCrystalForm' => MineralCrystalForm::orderBy('name')->pluck('name', 'id'),
            'mineralShine' => MineralShine::orderBy('name')->pluck('name', 'id'),
        ];
    }

    private function fossilSelectFields()
    {
        return [
            'invertebrates' => Invertebrate::orderBy('name')->pluck('name', 'id'),
            'indexFossils' => IndexFossil::orderBy('name')->pluck('name', 'id'),
        ];
    }

    private function getBreadcumbsParams(Request $request)
    {
        $id = (int) $request->query('id') ?? 0;
        $type = $request->query('type') ?? '';

        /** @var \App\Models\AbstractEntity $modelClass */
        $modelClass = \App\Helpers\Model::ClassByShortName($type);
        $routeName = '';
        $entity = '';

        if (empty($modelClass)) {
            return [$modelClass, $routeName, $entity];
        }
        $routeName = \App\Helpers\Model::infoRouteByName($type);
        if (empty($routeName)) {
            return [$modelClass, $routeName, $entity];
        }
        $entity = $modelClass::find($id);
        return [$routeName, $entity];
    }

}
