<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class AbstractMediaEntity extends Model
{

    protected $imagePathDetail;
    protected $imagePathGallery;
    protected $imagePathMicro;
    protected $commonImgPath;

    protected $guarded = ['photo', 'gallery', 'ppl', 'xpl'];

    const IMAGE_PATH_ROCK_MICRO = '/images/rocks/micro/';
    const IMAGE_PATH_MINERAL_MICRO = '/images/rocks/micro/';
    const IMAGE_PATH_FOSSIL_MICRO = '/images/rocks/micro/';



    public function __construct(array $attributes = [])
    {
        $this->imagePathDetail = $this->commonImgPath . 'detail/';
        $this->imagePathGallery = $this->commonImgPath . 'gallery/';
        $this->imagePathMicro = $this->commonImgPath . 'micro/';
        parent::__construct($attributes);
    }

    public static function getMicroPhotoPaths(string $publicPath): array
    {
        $path = $publicPath;
        if (!is_dir(public_path($path))) {
            return [];
        }
        $photos = array_values(array_diff(
            scandir(public_path($path)), ['.', '..']
        ));
        return array_map(function ($item) use ($path) {
                return env('APP_URL') . $path . '/' . $item;
            },
            $photos
        );
    }

    /**
     * Get path of detail page photo
     * @return string
     */
    public function getPhoto()
    {
        if (empty($this->photo)) {
            return '/img/no-image.png';
        }
        return $this->imagePathDetail . $this->photo . '?' . time();
    }

    /**
     * Upload detail page photo
     *
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
        $this->deleteImage($this->imagePathDetail . $this->photo);
        $filename = $this->getKey() . '.' . $photo->extension();
        $photo->storeAs($this->imagePathDetail, $filename);
        $this->photo = $filename;
        return $this;
    }

    /** TODO: remove image by path param */
    public function deleteImage($path)
    {
        if (!empty($path) && file_exists($path)) {
            Storage::delete($path);
        }
    }

    public function remove()
    {
        $this->deleteImage($this->imagePathDetail . $this->photo);
        //todo: remove gallery and micro photos
    }

    /**
     * @param UploadedFile[] $pplPhotos
     * @param UploadedFile[] $xplPhotos
     */
    public function uploadMicroscope(array $pplPhotos, array $xplPhotos)
    {
        $pplPath = $this->imagePathMicro . $this->id . '/ppl';
        $xplPath = $this->imagePathMicro . $this->id . '/xpl';
        Storage::deleteDirectory($pplPath);
        Storage::deleteDirectory($xplPath);
        // TODO: count($pplPhotos) == 36
        // TODO: flags: плавный переход, 5 или 10 градусов
        if (count($pplPhotos) > 0) {
            $this->saveImages2Dir($pplPhotos, $pplPath);
        }
        if (count($xplPhotos) > 0) {
            $this->saveImages2Dir($xplPhotos, $xplPath);
        }
    }

    /**
     * @param UploadedFile[] $items
     * @param string $path
     */
    private function saveImages2Dir(array $items, string $path)
    {
        $this->createDirIfNotExist($path);
        foreach ($items as $item) {
            $item->storeAs($path, $item->getClientOriginalName());
        }
    }

    private function createDirIfNotExist($dirPath)
    {
        return is_dir($dirPath) || Storage::makeDirectory($dirPath);
    }
    //TODO: gallery



}
