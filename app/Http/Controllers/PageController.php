<?php

namespace App\Http\Controllers;

use App\Models\Rock;
use App\Models\RockType;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function home()
    {
        //        dump(RockType::orderBy('name')->pluck('name', 'id'));
        return view('dist.index');
    }

    public function notfound()
    {
        return view('dist.404');
    }

    public function microscope()
    {
        return view('dist/microscope');
    }

}
