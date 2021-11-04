<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Each Rock can have several forming, second and accessory minerals
 *
 * Class Rock
 * @package App\Models
 */
class Rock extends Model
{
    use HasFactory;

    const IMAGE_PATH_ROCK_INFO = '/images/rocks/detail/';
    const IMAGE_PATH_ROCK_MICRO = '/images/rocks/micro/';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'photo', 'rock_type_id', 'forming_minerals', 'second_minerals', 'accessory_minerals', 'is_public'
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

    // TODO: add empty value in selectbox

    public function setRockType($id)
    {
        if (empty($id)) {
            return false;
        }
        if (empty(RockType::find($id))) {
            // TODO: maybe display error
            return false;
        }
        $this->rock_type_id = $id;
    }

    public function getRockTypeId()
    {
        if (empty($this->rockType)) {
            return '';
        }
        return $this->rockType->id ?? 0;
    }

    public function getRockTypeName()
    {
        if (empty($this->rockType)) {
            return '';
        }
        return $this->rockType->name ?? '';
    }

    public function rockClass()
    {
        return $this->belongsTo(RockClass::class);
    }

    public function setRockClass($id)
    {
        if (empty($id)) {
            return false;
        }
        if (empty(RockType::find($id))) {
            // TODO: maybe display error
            return false;
        }
        $this->rock_class_id = $id;
    }

    public function getRockClassId()
    {
        if (empty($this->rockClass)) {
            return '';
        }
        return $this->rockClass->id ?? 0;
    }

    public function getRockClassName()
    {
        if (empty($this->rockClass)) {
            return '';
        }
        return $this->rockClass->name ?? '';
    }

    // Use this for all dictionaries
    /**
     * @param string $class dictionary class name (rockType, rockClass, etc.)
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
     * @param string $class dictionary class name (rockType, rockClass, etc.)
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
        if (empty($id)) {
            return false;
        }
        if (empty(RockSquad::find($id))) {
            return false;
        }
        $this->rock_squad_id = $id;
    }


    public function getPhoto()
    {
        if (empty($this->photo)) {
            return '/img/no-image.png';
        }
        return self::IMAGE_PATH_ROCK_INFO . $this->photo . '?' . time();
    }

    /**
     * @param UploadedFile|null $photo
     * @return $this|false
     */
    public function uploadPhoto($photo)
    {
        if (empty($photo)) {
            return false;
        }

        // TODO: check that save and remove in correct path
        // replace Storage::delete by deleteImage()
        Storage::delete($this::IMAGE_PATH_ROCK_INFO . $this->photo);
        $filename = $this->getKey() . '.' . $photo->extension();
        $photo->storeAs($this::IMAGE_PATH_ROCK_INFO, $filename);
        $this->photo = $filename;
        return $this;
    }

    public function deleteImage()
    {
        if (!empty($this->photo)) {
            Storage::delete($this::IMAGE_PATH_ROCK_INFO . $this->photo);
        }
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
        return $this->getMineralLinkItems($this->formingMinerals);
    }
    public function getSecondMineralLinks()
    {
        return $this->getMineralLinkItems($this->secondMinerals);
    }
    public function getAccessoryMineralLinks()
    {
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
}
