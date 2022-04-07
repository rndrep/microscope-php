<?php

namespace App\Helpers;

use App\Models\AbstractMediaEntity;
use App\Models\Fossil;
use App\Models\Mineral;
use App\Models\Rock;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @param AbstractMediaEntity[] $entityItems
     * @param string $entityClass
     * @param string $infoRoute
     * @return array
     */
    public static function makeItemsLinks($entityItems, string $entityClass, string $infoRoute): array
    {
        if (!is_subclass_of($entityClass, AbstractMediaEntity::class)) {
            return [];
        }
        //$entityClass is child of AbstractMediaEntity
        $optProps = $entityClass::getOptionalProps();
        $result = [];
        foreach ($entityItems as $item) {
            $needAddLink = ($item->isPublic() || Auth::check())
                && $item->isAnyPropFilled($optProps);

            $result[] = [
                'link' => $needAddLink
                    ? route($infoRoute, $item->id)
                    : '',
                'name' => $item->name
            ];
        }
        return $result;
    }

    public static function makeRockLinks($rockRelation): array
    {
        $result = [];
        foreach ($rockRelation as $record) {
            $rock = Rock::find($record->rock_id);
            if (empty($rock)) {
                continue;
            }
            $needAddLink = $rock->isPublic() || Auth::check();
            $result['rock-' . $rock->id] = [
                'link' => $needAddLink
                    ? route('rock_info', $rock->id)
                    : '',
                'name' => $rock->name
            ];
        }
        return $result;
    }

}
