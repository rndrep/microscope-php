<?php

namespace App\Models;

use App\Classes\InfoField;
use App\Classes\InputField;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Each Rock can have several forming, second and accessory minerals
 *
 * Class Mineral
 * @package App\Models
 */
class Mineral extends AbstractMediaEntity
{
    use HasFactory;

    const ENTITY_CAPTION = 'Минералы';
    const ENTITY_NAME = 'minerals';

    public static function getInputs()
    {
        return [
            new InputField('Название', 'name', 'text', TRUE),
            new InputField('Описание', 'description', 'text'),
            new InputField('Химический состав', 'composition', 'text'),
            new InputField('Класс/подкласс', 'class', 'text'),
            new InputField('Видео', 'video', 'text'),
            new InputField('3D', 'model_3d', 'text'),
            new InputField('Разновидности', 'varieties', 'text'),
            new InputField('Форма выделения', 'aggregates', 'text'),
            new InputField('Черта', 'feature', 'text'),
//            new InputField('Сингония', 'syngony', 'text'),
            new InputField('Облик кристаллов', 'crystal_form', 'text'),
            new InputField('Твердость', 'hardness', 'number'),
            new InputField('Удельный вес, г/см3', 'specific_gravity', 'number'),
            new InputField('Цвет', 'color', 'text'),
            new InputField('Цвет черты', 'feature_color', 'text'),
            new InputField('Блеск', 'shine', 'text'),
            new InputField('Прозрачность', 'transparency', 'text'),
//            new InputField('Спайность', 'splitting', 'text'),
            new InputField('Прочие свойства', 'other_props', 'text'),
            new InputField('Диагностика', 'diagnosis', 'text'),
            new InputField('Генезис', 'genesis', 'text'),
            new InputField('Парагенезис', 'paragenesis', 'text'),
            new InputField('Долгота', 'x', 'text'),
            new InputField('Широта', 'y', 'text'),
        ];
    }

    public function getInfoFields()
    {
        $fields = [
            ['Химический состав', $this->composition],
            ['Класс/подкласс', $this->class],
            ['Разновидности', $this->varieties],
            ['Форма выделения', $this->aggregates],
            ['Черта', $this->feature],
            ['Облик кристаллов', $this->crystal_form],
            ['Твердость', $this->hardness],
            ['Удельный вес, г/см3', $this->specific_gravity],
            ['Цвет', $this->color],
            ['Цвет черты', $this->feature_color],
            ['Блеск', $this->shine],
            ['Прозрачность', $this->transparency],
            ['Прочие свойства', $this->other_props],
            ['Диагностика', $this->diagnosis],
            ['Генезис', $this->genesis],
            ['Парагенезис', $this->paragenesis],
            ['Сингония', $this->mineralSyngony->name ?? ''],
            ['Спайность', $this->mineralSplitting->name ?? ''],
        ];
        $result = [];
        foreach ($fields as $field) {
            if (!empty($field[1])) {
                $result[] = new InfoField($field[0], $field[1]);
            }
        }
        return $result;
    }

    public function getRockLinks(): array
    {
        $formingRocks = Rock_FormingMineral::where('mineral_id', $this->id)->get();
        $secondRocks = Rock_SecondMineral::where(['mineral_id' => $this->id])->get();
        $accessoryRocks = Rock_AccessoryMineral::where(['mineral_id' => $this->id])->get();

        $result = $this->makeRockLinks($formingRocks);
        $result = array_merge($result, $this->makeRockLinks($secondRocks));
        $result = array_merge($result, $this->makeRockLinks($accessoryRocks));

        return $result;
    }

    private function makeRockLinks($rockRelation)
    {
        $result = [];
        foreach ($rockRelation as $record) {
            $rock = Rock::find($record->rock_id);
            if (empty($rock)) {
                continue;
            }
            $result['rock-' . $rock->id] = [
                'link' => route('rock_info', $rock->id),
                'name' => $rock->name
            ];
        }
        return $result;
    }


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
        $this->delete();
    }

    private function deleteRelatedRocks()
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

    public function accessoryRocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__accessory_minerals',
            'mineral_id',
            'rock_id'
        );
    }

    public function mineralSyngony() //Сингония
    {
        return $this->belongsTo(MineralSyngony::class, 'syngony_id');
    }

    public function setMineralSyngony($id)
    {
        if (empty($id) || empty(MineralSyngony::find($id))) {
            $this->syngony_id = null;
        }
        $this->syngony_id = $id;
    }

    public function mineralSplitting() //Спайность
    {
        return $this->belongsTo(MineralSplitting::class, 'splitting_id');
    }

    public function setMineralSplitting($id)
    {
        if (empty($id) || empty(MineralSplitting::find($id))) {
            $this->splitting_id = null;
        }
        $this->splitting_id = $id;
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
