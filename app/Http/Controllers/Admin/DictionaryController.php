<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractDictionary;
use App\Models\Fossil;
use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Mineral;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
use App\Models\Rock;
use App\Models\RockType;
use App\Models\RockClass;
use App\Models\RockFamily;
use App\Models\RockKind;
use App\Models\RockSquad;
use App\Models\RockStructure;
use App\Models\RockTexture;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{

    const DICTIONARY_TO_RELATED_TABLE = [
        RockType::class => ['class' => Rock::class, 'prop' => 'rock_type_id'],
        RockClass::class => ['class' => Rock::class, 'prop' => 'rock_class_id'],
        RockFamily::class => ['class' => Rock::class, 'prop' => 'rock_family_id'],
        RockKind::class => ['class' => Rock::class, 'prop' => 'rock_kind_id'],
        RockSquad::class => ['class' => Rock::class, 'prop' => 'rock_squad_id'],
        RockStructure::class => ['class' => Rock::class, 'prop' => 'rock_structure_id'],
        RockTexture::class => ['class' => Rock::class, 'prop' => 'rock_texture_id'],
        MineralSyngony::class => ['class' => Mineral::class, 'prop' => 'syngony_id'],
        MineralSplitting::class => ['class' => Mineral::class, 'prop' => 'splitting_id'],
        Invertebrate::class => ['class' => Fossil::class, 'prop' => 'invertebrate_id'],
        IndexFossil::class => ['class' => Fossil::class, 'prop' => 'index_fossil_id'],
    ];

    public function all($modelClass)
    {
        $this->abortIfNoModel(class_basename($modelClass));

        /** @var AbstractDictionary $modelClass */
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
        // not used
    }

    public function create(Request $request)
    {
        // edit() is used instead of create()
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

        $modelClass = 'App\Models\\' .$entity;
        $item = $id ? $modelClass::find($id) : false;
        return view('admin.entity.editor', [
            'entityCaption' => $modelClass::ENTITY_CAPTION,
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

    public function destroy(Request $request)
    {
        $entity = $request->query('entity');
        $id = $request->query('id');
        $this->abortIfNoModel($entity);

        $modelClass = 'App\Models\\' .$entity;
        if (!empty($id)) {
            if ($this->canBeRemoved($modelClass, $id)) {
                $modelClass::find($id)->delete();
            } else {
                return 'Нельзя удалить, значение справочника используется.';
            }
        }
        return redirect()->route('get_all_dicts', $entity);
    }

    private function abortIfNoModel($basename)
    {
        if (!class_exists('App\Models\\' . $basename)) {
            abort(404);
        };
    }

    private function canBeRemoved($modelClass, $id)
    {
        $relatedTable = self::DICTIONARY_TO_RELATED_TABLE[$modelClass]['class'];
        $foreignKeyProp = self::DICTIONARY_TO_RELATED_TABLE[$modelClass]['prop'];
        return empty($relatedTable::where($foreignKeyProp, $id)->count());
    }

}
