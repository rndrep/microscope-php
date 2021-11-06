<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Each Rock can have several forming, second and accessory minerals
 *
 * Class Rock
 * @package App\Models
 */
class Rock extends AbstractMediaEntity
{
    use HasFactory;

    const IMAGE_PATH_ROCK_MICRO = '/images/rocks/micro/';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->imagePathDetail = '/images/rocks/detail/';
        $this->imagePathGallery = '/images/rocks/gallery/';
    }

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'photo', 'video', 'rock_type_id', 'rock_class_id', 'rock_squad_id', 'rock_family_id', 'rock_kind_id',
        'rock_texture_id', 'rock_structure_id', 'forming_minerals', 'second_minerals', 'accessory_minerals', 'is_public'
    ];

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->deleteImage();
        $this->deleteRelatedMinerals();
        $this->delete();
    }

    public function rockType()
    {
        return $this->belongsTo(RockType::class);
    }

    public function setRockType($id)
    {
        if (empty($id) || empty(RockType::find($id))) {
            $this->rock_type_id = null;
        }
        $this->rock_type_id = $id;
    }

    public function rockClass()
    {
        return $this->belongsTo(RockClass::class);
    }

    public function setRockClass($id)
    {
        if (empty($id) || empty(RockClass::find($id))) {
            $this->rock_class_id = null;
        }
        $this->rock_class_id = $id;
    }

    // Use this for all dictionaries
    /**
     * @param string $class dictionary id (rockType, rockClass, etc.)
     * @return int
     */
    public function getDictionaryPropId(string $class)
    {
        $relation = lcfirst($class);
        if (empty($this->$relation)) {
            return '';
        }
        return $this->$relation->id ?? 0;
    }

    /**
     * @param string $class dictionary name (rockType, rockClass, etc.)
     * @return string
     */
    public function getDictionaryPropName(string $class)
    {
        $relation = lcfirst($class);
        if (empty($this->$relation)) {
            return '';
        }
        return $this->$relation->name ?? '';
    }

    public function rockSquad()
    {
        return $this->belongsTo(RockSquad::class);
    }

    public function setRockSquad($id)
    {
        if (empty($id) || empty(RockSquad::find($id))) {
            $this->rock_squad_id = null;
        }
        $this->rock_squad_id = $id;
    }

    public function rockFamily()
    {
        return $this->belongsTo(RockFamily::class);
    }

    public function setRockFamily($id)
    {
        if (empty($id) || empty(RockFamily::find($id))) {
            $this->rock_family_id = null;
        }
        $this->rock_family_id = $id;
    }

    public function rockKind()
    {
        return $this->belongsTo(RockKind::class);
    }

    public function setRockKind($id)
    {
        if (empty($id) || empty(RockKind::find($id))) {
            $this->rock_kind_id = null;
        }
        $this->rock_kind_id = $id;
    }

    public function rockTexture()
    {
        return $this->belongsTo(RockTexture::class);
    }

    public function setRockTexture($id)
    {
        if (empty($id) || empty(RockTexture::find($id))) {
            $this->rock_texture_id = null;
        }
        $this->rock_texture_id = $id;
    }

    public function rockStructure()
    {
        return $this->belongsTo(RockStructure::class);
    }

    public function setRockStructure($id)
    {
        if (empty($id) || empty(RockStructure::find($id))) {
            $this->rock_structure_id = null;
        }
        $this->rock_structure_id = $id;
    }

    public function fossil()
    {
        return $this->belongsTo(Fossil::class);
    }

    public function setFossil($id)
    {
        if (empty($id) || empty(Fossil::find($id))) {
            $this->fossil_id = null;
        }
        $this->fossil_id = $id;
    }

    public function formingMinerals()
    {
        return $this->belongsToMany(
            Mineral::class,
            'rock__forming_minerals',
            'rock_id',
            'mineral_id'
        );
    }

    public function secondMinerals()
    {
        return $this->belongsToMany(
            Mineral::class,
            'rock__second_minerals',
            'rock_id',
            'mineral_id'
        );
    }

    public function accessoryMinerals()
    {
        return $this->belongsToMany(
            Mineral::class,
            'rock__accessory_minerals',
            'rock_id',
            'mineral_id'
        );
    }

    public function getFormingMineralName()
    {
        return implode(', ', $this->formingMinerals->pluck('name')->all());
    }

    public function getSecondMineralName()
    {
        return implode(', ', $this->secondMinerals->pluck('name')->all());
    }

    public function getAccessoryMineralName()
    {
        return implode(', ', $this->accessoryMinerals->pluck('name')->all());
    }

    public function getFormingMineralLinks()
    {
        if (!isset($this->formingMinerals)) {
            return [];
        }
        return $this->getMineralLinkItems($this->formingMinerals);
    }
    public function getSecondMineralLinks()
    {
        if (!isset($this->secondMinerals)) {
            return [];
        }
        return $this->getMineralLinkItems($this->secondMinerals);
    }
    public function getAccessoryMineralLinks()
    {
        if (!isset($this->accessoryMinerals)) {
            return [];
        }
        return $this->getMineralLinkItems($this->accessoryMinerals);
    }

    private function getMineralLinkItems($minerals)
    {
        $optProps = Mineral::getOptionalProps();
        $result = [];
        foreach ($minerals as $mineral) {
            $needAddLink = FALSE;
            foreach ($optProps as $optProp) {
                if (!empty($mineral->{$optProp})) {
                    $needAddLink = TRUE;
                    break;
                }
            }
            $result[] = [
                'link' => $needAddLink
                    ? route('mineral_info', $mineral->id)
                    : '',
                'name' => $mineral->name
            ];
        }
        return $result;
    }

    public function setFormingMinerals($ids)
    {
        if (empty($ids)) {
            return false;
        }
        $this->formingMinerals()->sync($ids);
    }

    public function setSecondMinerals($ids)
    {
        if (empty($ids)) {
            return false;
        }
        $this->secondMinerals()->sync($ids);
    }

    public function setAccessoryMinerals($ids)
    {
        if (empty($ids)) {
            return false;
        }
        $this->accessoryMinerals()->sync($ids);
    }

    public function deleteRelatedMinerals()
    {
        Rock_FormingMineral::where('rock_id', $this->id)->delete();
        Rock_SecondMineral::where('rock_id', $this->id)->delete();
        Rock_AccessoryMineral::where('rock_id', $this->id)->delete();
    }

    public function isPublic()
    {
        return $this->is_public;
    }

    public function toggleStatus($value)
    {
        if(empty($value))
        {
            $this->unpublish();
        } else {
            $this->publish();
        }
    }

    public function publish()
    {
        $this->is_public = 1;
    }

    public function unpublish()
    {
        $this->is_public = 0;
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

}
