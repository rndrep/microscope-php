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
class Mineral extends AbstractMediaEntity
{
    use HasFactory;

    // TODO: add flag 'required'
    const SIMPLE_INPUT_FIELDS = [
        'Название' => 'name',
        'Описание' => 'description',
        'Cостав' => 'composition',
        'Класс/подкласс' => 'class',
        'Видео' => 'video',
        'Разновидности' => 'varieties',
        'Форма выделения' => 'aggregates',
        'Черта' => 'feature',
        'Сингония' => 'syngony',
        'Облик кристаллов' => 'crystal_form',
        'Твердость' => 'hardness',
        'Удельный вес, г/см3' => 'specific_gravity',
        'Цвет' => 'color',
        'Цвет черты' => 'feature_color',
        'Блеск' => 'shine',
        'Прозрачность' => 'transparency',
        'Спайность' => 'splitting',
        'Прочие свойства' => 'other_props',
        'Диагностика' => 'diagnosis',
        'Генезис' => 'genesis',
        'Парагенезис' => 'paragenesis',
        'Долгота' => 'x',
        'Широта' => 'y',
//        'Месторождение' => '',
    ];

    public function __construct(array $attributes = [])
    {
        $this->commonImgPath = '/images/minerals/';
        parent::__construct($attributes);

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

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function remove()
    {
        parent::remove();
        //TODO: check
        $this->deleteRelatedRocks();
    }

    public function deleteRelatedRocks()
    {
        Rock_FormingMineral::where('mineral_id', $this->id)->delete();
        Rock_SecondMineral::where('mineral_id', $this->id)->delete();
        Rock_AccessoryMineral::where('mineral_id', $this->id)->delete();
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

    public function getVarieties() //Разновидности
    {
        return $this->varieties;
    }

    public function setVarieties($value): self
    {
        $this->varieties = $value;
        return $this;
    }

    public function getAggregates() //Форма выделения ( по другому агрегаты)
    {
        return $this->aggregates;
    }

    public function setAggregates($value): self
    {
        $this->aggregates = $value;
        return $this;
    }

    public function getFeature() //Черта
    {
        return $this->feature;
    }

    public function setFeature($value): self
    {
        $this->feature = $value;
        return $this;
    }

    public function getSyngony() //Сингония
    {
        return $this->syngony;
    }

    public function setSyngony($value): self
    {
        $this->syngony = $value;
        return $this;
    }

    public function getCrystalForm() //Облик кристаллов
    {
        return $this->crystal_form;
    }

    public function setCrystalForm($value): self
    {
        $this->crystal_form = $value;
        return $this;
    }

    public function getHardness() //Твердость
    {
        return $this->hardness;
    }

    public function setHardness($value): self
    {
        $this->hardness = $value;
        return $this;
    }

    public function getSpecificGravity() //Удельный вес, г/см3
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

    public function getFeatureColor() //Цвет черты
    {
        return $this->feature_color;
    }

    public function setFeatureColor($value): self
    {
        $this->feature_color = $value;
        return $this;
    }

    public function getShine() //Блеск
    {
        return $this->shine;
    }

    public function setShine($value): self
    {
        $this->shine = $value;
        return $this;
    }

    public function getTransparency() //Прозрачность
    {
        return $this->transparency;
    }

    public function setTransparency($value): self
    {
        $this->transparency = $value;
        return $this;
    }

    public function getSplitting() //Спайность
    {
        return $this->splitting;
    }

    public function setSplitting($value): self
    {
        $this->splitting = $value;
        return $this;
    }

    public function getOtherProps() //Прочие свойства
    {
        return $this->other_props;
    }

    public function setOtherProps($value): self
    {
        $this->other_props = $value;
        return $this;
    }

    public function getDiagnosis() //Диагностика
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
