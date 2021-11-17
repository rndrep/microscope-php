<?php

namespace App\Models;

use App\Classes\InputField;

class AbstractDictionary extends \Illuminate\Database\Eloquent\Model
{

    public static function getInputs()
    {
        return [
            new InputField('Название', 'name', 'text', TRUE),
            new InputField('Описание', 'description', 'text'),
        ];
    }

}
