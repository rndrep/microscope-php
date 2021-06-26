<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rock;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //TODO: add sorting
        $categories = Category::all();
        return view('admin.category.index', ['items' => $categories]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $item = Category::find($id);
        return view('admin.category.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'	=>	'required' //обязательно
        ]);
        $item = Category::find($id);
        $item->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        if (Rock::firstWhere('category_id', $id)) {
            //TODO: add custom error in template
            return 'Нельзя удалить категорию. Существует порода с данной категорией.';
        }
        Category::find($id)->delete();
        return redirect()->route('categories.index');
    }
}
