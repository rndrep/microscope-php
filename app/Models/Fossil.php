<?php

namespace App\Models;

use App\Classes\InfoField;
use App\Classes\InputField;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fossil extends AbstractMediaEntity
{
    use HasFactory;

    const ENTITY_CAPTION = 'Окаменелости';
    const ENTITY_NAME = 'fossils';

    const PHOTO_INFO_PATH = '/images/fossils/detail/';
    const MICRO_PATH = '/images/fossils/micro/';
    const GALLERY_PATH = '/images/fossils/gallery/';

    public function __construct(array $attributes = [])
    {
        $this->commonImgPath = '/images/fossils/';
//        $this->guarded = array_merge($this->guarded, []);
        parent::__construct($attributes);
    }

    public static function getInputs()
    {
        return [
            new InputField('Название', 'name', 'text', 'true'),
            new InputField('Описание', 'description', 'text'),
            new InputField('Видео', 'video', 'text'),
            new InputField('3D', 'model_3d', 'text'),
//            new InputField('Типы беспозвоночных животных', 'invertebrate', 'text'),
//            new InputField('Руководящие формы', 'index_fossil', 'text'),
        ];
    }

    public function getInfoFields()
    {
        $fields = [
            ['Типы беспозвоночных животных', $this->invertebrate->name ?? ''],
            ['Руководящие формы', $this->indexFossil->name ?? ''],
        ];
        $result = [];
        foreach ($fields as $field) {
            if (!empty($field[1])) {
                $result[] = new InfoField($field[0], $field[1]);
            }
        }
        return $result;
    }

    public function getRockLinks(): array
    {
        $rocks = Rock_Fossil::where('fossil_id', $this->id)->get();
        return $this->makeRockLinks($rocks);
    }

    private function makeRockLinks($rockRelation)
    {
        $result = [];
        foreach ($rockRelation as $record) {
            $rock = Rock::find($record->rock_id);
            if (empty($rock)) {
                continue;
            }
            $result['rock-' . $rock->id] = [
                'link' => route('rock_info', $rock->id),
                'name' => $rock->name
            ];
        }
        return $result;
    }

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        parent::remove();
        $this->deleteRelatedRocks();
        $this->delete();
    }

    private function deleteRelatedRocks()
    {
        Rock_Fossil::where('fossil_id', $this->id)->delete();
    }

    public static function getOptionalProps(): array
    {
        return [
            'description',
            'photo',
            'video',
            'model_3d',
            'invertebrate_id',
            'index_fossil_id',
        ];
    }

    public function rocks()
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__fossils',
            'fossil_id',
            'rock_id'
        );
    }

    public function invertebrate()
    {
        return $this->belongsTo(Invertebrate::class);
    }

    public function setInvertebrate($id)
    {
        if (empty($id) || empty(Invertebrate::find($id))) {
            $this->invertebrate_id = null;
            return $this;
        }
        $this->invertebrate_id = $id;
        return $this;
    }

    public function indexFossil()
    {
        return $this->belongsTo(IndexFossil::class);
    }

    public function setIndexFossil($id)
    {
        if (empty($id) || empty(Invertebrate::find($id))) {
            $this->index_fossil_id = null;
            return $this;
        }
        $this->index_fossil_id = $id;
        return $this;
    }

}
