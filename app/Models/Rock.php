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

    const IMAGE_PATH_ROCK_INFO = 'images/rocks/detail/';
    const IMAGE_PATH_ROCK_MICRO = 'images/rocks/microscope/';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function rockType()
    {
        return $this->belongsTo(RockType::class);
    }

    public function getRockTypeName()
    {
        if (empty($this->rockType)) {
            return '';
        }
        return $this->rockType->name ?? '';
    }

    public function getImage()
    {
        if (empty($this->photo)) {
            return '/img/no-image.png';
        }
        return self::IMAGE_PATH_ROCK_INFO . $this->photo;
    }

    public function uploadImage(UploadedFile $image): bool
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
        return true;
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
        $names = [];
        foreach ($this->formingMinerals as $item) {
            $names[] = $item->name;
        }
        return implode(', ', $names);
    }

    public function getSecondMineralName()
    {
        $names = [];
        foreach ($this->secondMinerals as $item) {
            $names[] = $item->name;
        }
        return implode(', ', $names);
    }

    public function getAccessoryMineralName()
    {
        $names = [];
        foreach ($this->accessoryMinerals as $item) {
            $names[] = $item->name;
        }
        return implode(', ', $names);

    }

}
