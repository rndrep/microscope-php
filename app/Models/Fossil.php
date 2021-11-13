<?php

namespace App\Models;

use App\Classes\InputField;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fossil extends AbstractMediaEntity
{
    use HasFactory;

    const ENTITY_CAPTION = 'Окаменелости';
    const ENTITY_NAME = 'fossils';

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
            new InputField('Типы беспозвоночных животных', 'invertebrates', 'text'),
            new InputField('Руководящие формы', 'index_fossils', 'text'),
        ];
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
        return ['description'];
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


}
