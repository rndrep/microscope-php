<?php

namespace App\Classes;

class Dictionary
{

    const DICTIONARIES = [
        ['caption' => 'Типы пород', 'class' => ''],
        ['caption' => 'Отряды пород', 'class' => ''],
        ['caption' => 'Классы пород', 'class' => ''],
        ['caption' => 'Семейства пород', 'class' => ''],
        ['caption' => 'Виды пород', 'class' => ''],
        ['caption' => 'Текстуры пород', 'class' => ''],
        ['caption' => 'Структуры пород', 'class' => ''],
        ['caption' => 'Сингония ', 'class' => ''],
        ['caption' => 'Спайность', 'class' => ''],
        ['caption' => 'Типы беспозвоночных животных', 'class' => ''],
        ['caption' => 'Руководящие формы', 'class' => ''],
    ];

    public static function getDicts(): array
    {
        $result = [];
        foreach (self::DICTIONARIES as $item) {
            $dictObj = new \stdClass();
            $dictObj->caption = $item['caption'];
            $result[] = $dictObj;
        }
        return $result;
    }
}
