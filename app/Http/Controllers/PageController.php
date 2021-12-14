<?php

namespace App\Http\Controllers;

use App\Models\AbstractMediaEntity;
use App\Models\Fossil;
use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Mineral;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
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

    public function microscope()
    {
        return view('dist/microscope');
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
                $tmpObj->point = $item->getPoint();
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
                $tmpObj->point = $item->getPoint();
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
