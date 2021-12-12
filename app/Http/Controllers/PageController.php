<?php

namespace App\Http\Controllers;

use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Mineral;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
use App\Models\RockClass;
use App\Models\RockKind;
use App\Models\RockType;
use Illuminate\Http\Request;

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
