<?php

namespace App\Classes;

use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\MineralSplitting;
use App\Models\MineralSyngony;
use App\Models\RockClass;
use App\Models\RockFamily;
use App\Models\RockKind;
use App\Models\RockSquad;
use App\Models\RockStructure;
use App\Models\RockTexture;
use App\Models\RockType;

class Dictionary
{

    //TODO: maybe use class name: 'RockType' instead of RockType::class
    const DICTIONARIES = [
        ['caption' => 'Типы пород', 'class' => RockType::class],
        ['caption' => 'Отряды пород', 'class' => RockSquad::class],
        ['caption' => 'Классы пород', 'class' => RockClass::class],
        ['caption' => 'Семейства пород', 'class' => RockFamily::class],
        ['caption' => 'Виды пород', 'class' => RockKind::class],
        ['caption' => 'Текстуры пород', 'class' => RockTexture::class],
        ['caption' => 'Структуры пород', 'class' => RockStructure::class],
        ['caption' => 'Сингония ', 'class' => MineralSyngony::class],
        ['caption' => 'Спайность', 'class' => MineralSplitting::class],
        ['caption' => 'Типы беспозвоночных животных', 'class' => Invertebrate::class],
        ['caption' => 'Руководящие формы', 'class' => IndexFossil::class],
    ];

    public static function getDicts(): array
    {
        $result = [];
        foreach (self::DICTIONARIES as $item) {
            $dictObj = new \stdClass();
            $dictObj->caption = $item['caption'];
            $dictObj->class = $item['class'];
            $result[] = $dictObj;
        }
        return $result;
    }

}
