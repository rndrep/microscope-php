<?php

namespace App\Http\Controllers;

use App\Models\Rock;
use App\Models\RockType;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    const ITEMS_PER_PAGE = 2;

    public function home()
    {
        $queryBuilder = Rock::query();
        if (!Auth::check()) {
            $queryBuilder->where('is_public', 1);
        }
        return view(
            'dist.index',
            ['items' => $queryBuilder->orderBy('name')->paginate(self::ITEMS_PER_PAGE)]
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

}
