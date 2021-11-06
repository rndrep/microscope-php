<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Support\Str;

/**
 * Each Rock can have several forming, second and accessory minerals
 *
 * Class Mineral
 * @package App\Models
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->imagePathDetail = '/images/minerals/detail/';
        $this->imagePathGallery = '/images/minerals/gallery/';
    }

//doesn't work with Mineral::pluck
//TODO: need to make getters ans setters
//    public function __call($name, $arguments)
//    {
//        //do a get
//        if (preg_match('/^get(.+)/', $name, $matches)) {
//            $varName = Str::snake($matches[1]);
//            return $this->$varName;
//        }
//        //do a set
//        if (preg_match('/^set(.+)/', $name, $matches)) {
//            $varName = Str::snake($matches[1]);
//            $this->$varName = $arguments[0];
//        }
////        call_user_func($name, $arguments);
//    }

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($value): self
    {
        $this->name = $value;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value): self
    {
        $this->description = $value;
        return $this;
    }

    public function getComposition()
    {
        return $this->composition;
    }

    public function setComposition($value): self
    {
        $this->composition = $value;
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($value): self
    {
        $this->class = $value;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($value): self
    {
        $this->photo = $value;
        return $this;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function setVideo($value): self
    {
        $this->video = $value;
        return $this;
    }

    public function getVarieties()
    {
        return $this->varieties;
    }

    public function setVarieties($value): self
    {
        $this->varieties = $value;
        return $this;
    }

    public function getAggregates()
    {
        return $this->aggregates;
    }

    public function setAggregates($value): self
    {
        $this->aggregates = $value;
        return $this;
    }

    public function getFeature()
    {
        return $this->feature;
    }

    public function setFeature($value): self
    {
        $this->feature = $value;
        return $this;
    }

    public function getSyngony()
    {
        return $this->syngony;
    }

    public function setSyngony($value): self
    {
        $this->syngony = $value;
        return $this;
    }

    public function getCrystalForm()
    {
        return $this->crystal_form;
    }

    public function setCrystalForm($value): self
    {
        $this->crystal_form = $value;
        return $this;
    }

    public function getHardness()
    {
        return $this->hardness;
    }

    public function setHardness($value): self
    {
        $this->hardness = $value;
        return $this;
    }

    public function getSpecificGravity()
    {
        return $this->specific_gravity;
    }

    public function setSpecificGravity($value): self
    {
        $this->specific_gravity = $value;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($value): self
    {
        $this->color = $value;
        return $this;
    }

    public function getFeatureColor()
    {
        return $this->feature_color;
    }

    public function setFeatureColor($value): self
    {
        $this->feature_color = $value;
        return $this;
    }

    public function getShine()
    {
        return $this->shine;
    }

    public function setShine($value): self
    {
        $this->shine = $value;
        return $this;
    }

    public function getTransparency()
    {
        return $this->transparency;
    }

    public function setTransparency($value): self
    {
        $this->transparency = $value;
        return $this;
    }

    public function getOtherProps()
    {
        return $this->other_props;
    }

    public function setOtherProps($value): self
    {
        $this->other_props = $value;
        return $this;
    }

    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    public function setDiagnosis($value): self
    {
        $this->diagnosis = $value;
        return $this;
    }

    public function getGenesis()
    {
        return $this->genesis;
    }

    public function setGenesis($value): self
    {
        $this->genesis = $value;
        return $this;
    }

    public function getParagenesis()
    {
        return $this->paragenesis;
    }

    public function setParagenesis($value): self
    {
        $this->paragenesis = $value;
        return $this;
    }

}
