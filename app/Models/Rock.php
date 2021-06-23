<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function formingMineral()
    {
        $this->belongsTo(Mineral::class, 'forming_mineral_id');

    }

    public function accessoryMineral()
    {
        $this->belongsTo(Mineral::class, 'accessory_mineral_id');

    }

    public function rockType()
    {
        $this->belongsTo(RockType::class);
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

}
