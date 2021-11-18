<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractDictionary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{

    public function all($modelClass)
    {
        $this->abortIfNoModel(class_basename($modelClass));

        $modelClass = 'App\Models\\' . $modelClass;
        $items = $modelClass::orderBy('name')->get();
        return view('admin.entity.index', [
            'entityCaption' => $modelClass::ENTITY_CAPTION,
            'entityName' => class_basename($modelClass),
            'items' => $items,
            'fields' => $modelClass::getInputs()]);
    }

    public function index($modelClass)
    {
        //
    }

    public function create(Request $request)
    {
        $entity = $request->query('entity');
        $this->abortIfNoModel($entity);

        return view('admin.entity.editor', [
            'entityName' => $entity,
            'item' => false,
        ]);
    }

    public function store()
    {
        // update() is used instead of store()
    }

    public function edit(Request $request)
    {
        /** @var AbstractDictionary $entity */
        $entity = $request->query('entity');
        $id = $request->query('id');
        $this->abortIfNoModel($entity);

        if (empty($id)) {
            return $this->create($request);
        }

        $modelClass = 'App\Models\\' .$entity;
        $item = $modelClass::find($id);
        return view('admin.entity.editor', [
            'entityName' => $entity,
            'item' => $item,
        ]);
    }

    public function update(Request $request)
    {
        $entity = $request->query('entity');
        $id = $request->query('id');
        $this->abortIfNoModel($entity);

        $this->validate($request, [
            'name'	=>	'required'
        ]);
        $modelClass = 'App\Models\\' .$entity;

        if (empty($id)) {
            $modelClass::add($request->all());
        } else {
            $item = $modelClass::find($id);
            $item->update($request->all());
        }
        return redirect()->route('get_all_dicts', $entity);
    }

    public function destroy()
    {
        $entity = $request->query('entity');
        $id = $request->query('id');
        $this->abortIfNoModel($entity);

        $modelClass = 'App\Models\\' .$entity;
        if (!empty($id)) {
            //TODO: check that entity is not used
            $canBeDeleted = false;
//            if (Rock::firstWhere('rock_type_id', $id)) {
//                return 'Нельзя удалить тип породы. Существует порода с данным типом.';
//            }
            $entity::find($id)->delete();
        }
        return redirect()->route('get_all_dicts', $entity);
    }

    private function abortIfNoModel($basename)
    {
        if (!class_exists('App\Models\\' . $basename)) {
            abort(404);
        };
    }
}
