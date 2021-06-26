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
    const IMAGE_PATH_ROCK_MICRO = '/images/rocks/microscope/';

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

    public function isPublic()
    {
        return $this->is_public;
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
        $this->save();
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

    public function getPhoto()
    {
        if (empty($this->photo)) {
            return '/img/no-image.png';
        }
        return self::IMAGE_PATH_ROCK_INFO . $this->photo . '?' . time();
    }

    /**
     * @param UploadedFile|null $image
     * @return $this|false
     */
    public function uploadImage($image)
    {
        if (empty($image)) {
            return false;
        }

        // TODO: check that save and remove in correct path
        Storage::delete($this::IMAGE_PATH_ROCK_INFO . $this->photo);
        $filename = $this->getKey() . '.' . $image->extension();
        $image->storeAs($this::IMAGE_PATH_ROCK_INFO, $filename);
        $this->photo = $filename;
        $this->save();
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
        //TODO: remove minerals before remove rock
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
        $this->save();
    }

    public function unpublish()
    {
        $this->is_public = 0;
        $this->save();
    }
}
