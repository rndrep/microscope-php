<?php

namespace App\Classes;

use App\Models\AbstractDictionary;
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

    const DICTIONARIES = [
        RockType::class,
        RockSquad::class,
        RockClass::class,
        RockFamily::class,
        RockKind::class,
        RockTexture::class,
        RockStructure::class,
        MineralSyngony::class,
        MineralSplitting::class,
        Invertebrate::class,
        IndexFossil::class,
    ];
    public static function getDicts(): array
    {
        $result = [];
        /** @var AbstractDictionary $item */
        foreach (self::DICTIONARIES as $item) {
            $dictObj = new \stdClass();
            $dictObj->caption = $item::ENTITY_CAPTION;
            $dictObj->class = class_basename($item);
            $result[] = $dictObj;
        }
        return $result;
    }

}
