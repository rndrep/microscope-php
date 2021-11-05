<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Each Rock can have several forming, second and accessory minerals
 *
 * Class Mineral
 * @package App\Models
 *
 * @method getName()
 * @method setName($value)
 * @method getDescription()
 * @method setDescription($value)
 * @method getComposition()
 * @method setComposition($value)
 * @method getClass()
 * @method setClass($value)
 * @method getPhoto()
 * @method setPhoto($value)
 * @method getVideo()
 * @method setVideo($value)
 * @method getVarieties()
 * @method setVarieties()
 * @method getAggregates()
 * @method setAggregates()
 * @method getFeature()
 * @method setFeature()
 * @method getSyngony()
 * @method setSyngony()
 * @method getCrystalForm()
 * @method setCrystalForm()
 * @method getHardness()
 * @method setHardness()
 * @method getSpecificGravity()
 * @method setSpecificGravity()
 * @method getColor()
 * @method setColor()
 * @method getFeatureColor()
 * @method setFeatureColor()
 * @method getShine()
 * @method setShine()
 * @method getTransparency()
 * @method setTransparency()
 * @method getOtherProps()
 * @method setOtherProps()
 * @method getDiagnosis()
 * @method setDiagnosis()
 * @method getGenesis()
 * @method setGenesis()
 * @method getParagenesis()
 * @method setParagenesis()
 */
class Mineral extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function __call($name, $arguments)
    {
        //do a get
        if (preg_match('/^get(.+)/', $name, $matches)) {
            $varName = Str::snake($matches[1]);
            return $this->$varName;
        }
        //do a set
        if (preg_match('/^set(.+)/', $name, $matches)) {
            $varName = Str::snake($matches[1]);
            $this->$varName = $arguments[0];
        }
    }

    public static function getOptionalProps()
    {
        return ['description'];
    }

    public function formingRocks()
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__forming_minerals',
            'mineral_id',
            'rock_id'
        );
    }

    public function secondRocks()
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__second_minerals',
            'mineral_id',
            'rock_id'
        );
    }

    public function accessoryRocks()
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__accessory_minerals',
            'mineral_id',
            'rock_id'
        );
    }

    public function getLocation()
    {
        $point = new \stdClass();
        $point->x = $this->x;
        $point->y = $this->y;
        return $point;
    }

}
