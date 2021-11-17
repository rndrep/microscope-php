<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DictionaryController extends Controller
{

    public function all($modelClass)
    {
        $items = $modelClass::orderBy('name')->get();
        return view('admin.entity.index', [
//            'entityCaption' => Mineral::ENTITY_CAPTION,
//            'entityName' => Mineral::ENTITY_NAME,
            'items' => $items,
            'fields' => $modelClass::getInputs()]);
    }

    public function index($modelClass)
    {
        //
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
