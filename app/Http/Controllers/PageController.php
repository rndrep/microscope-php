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
        $mapType2Route = ['rock' => 'rock_info', 'mineral' => 'mineral_info', 'fossil' => 'fossil_info'];
        $id = $request->query('id') ?? '';
        $type = $request->query('type') ?? '';
        $viewParams = [];
        if ($id && $type) {
            $viewParams['routeName'] = $mapType2Route[$type];
            $viewParams['itemId'] = $id;
            $viewParams['itemName'] = 'qwert'; // TODO: get item name from DB (need get model class)
        }
        return view('dist/microscope', $viewParams);
    }

    public function rotation(Request $request)
    {
        $src = $request->query('src');
        return view('dist/rotation', ['src' => $src]);
    }

    public function map()
    {
        return view('dist/map');
    }

    /**
     * TODO: write about what this method
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapItems()
    {
        $result = [];
        //TODO: use is_public
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

}
