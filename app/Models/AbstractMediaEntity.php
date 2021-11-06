<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class AbstractMediaEntity extends Model
{

    protected $imagePathDetail;
    protected $imagePathGallery;

    public function getPhoto()
    {
        if (empty($this->photo)) {
            return '/img/no-image.png';
        }
        return $this->imagePathDetail . $this->photo . '?' . time();
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
        Storage::delete($this->imagePathDetail . $this->photo);
        $filename = $this->getKey() . '.' . $photo->extension();
        $photo->storeAs($this->imagePathDetail, $filename);
        $this->photo = $filename;
        return $this;
    }

    public function deleteImage()
    {
        if (!empty($this->photo)) {
            Storage::delete($this->imagePathDetail . $this->photo);
        }
    }

    //TODO: gallery

}
