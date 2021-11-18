<?php

namespace App\Models;

use App\Classes\InputField;

class AbstractDictionary extends \Illuminate\Database\Eloquent\Model
{

    const ENTITY_CAPTION = 'Словарь';

    protected $fillable = [
        'name',
        'description',
    ];

    public static function getInputs()
    {
        return [
            new InputField('Название', 'name', 'text', TRUE),
            new InputField('Описание', 'description', 'text'),
        ];
    }

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function remove()
    {
        //TODO: check that entity is not used
//        $this->delete();
    }

}
