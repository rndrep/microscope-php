<?php

namespace App\Http\Controllers;

class PageController extends Controller
{

    public function notfound()
    {
        return view('dist.404');
    }

    public function microscope()
    {
        return view('dist/microscope');
    }

}
