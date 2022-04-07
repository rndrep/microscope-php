<?php

namespace App\Helpers;

use App\Models\Fossil;
use App\Models\Mineral;
use App\Models\Rock;

class Model
{

    const NAME_ROCK = 'rock';
    const NAME_MINERAL = 'mineral';
    const NAME_FOSSIL = 'fossil';

    const SHORT_NAME_TO_CLASS = [
        self::NAME_ROCK => Rock::class,
        self::NAME_MINERAL => Mineral::class,
        self::NAME_FOSSIL => Fossil::class,
    ];

   const SHORT_NAME_TO_ROUTE = [
       self::NAME_ROCK => 'rock_info',
       self::NAME_MINERAL => 'mineral_info',
       self::NAME_FOSSIL => 'fossil_info'
   ];


    public static function ClassByShortName(string $name): string
    {
        return self::SHORT_NAME_TO_CLASS[$name] ?? '';
    }

    public static function ShortNameByClass(string $class)
    {
        return array_flip(self::SHORT_NAME_TO_CLASS)[$class] ?? '';
    }

    public static function infoRouteByName(string $name): string
    {
        return self::SHORT_NAME_TO_ROUTE[$name] ?? '';
    }

}
