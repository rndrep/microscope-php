<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class AbstractMediaEntity extends AbstractEntity
{

    protected $imagePathDetail;
    protected $imagePathGallery;
    protected $imagePathMicro;
    protected $commonImgPath; // duplicated logic of path constants (PHOTO_INFO_PATH, MICRO_PATH, GALLERY_PATH)

    protected $guarded = ['photo', 'gallery', 'ppl', 'xpl'];

    const PHOTO_INFO_PATH = '';
    const MICRO_PATH = '';
    const GALLERY_PATH = '';

    const CONTENT_TYPE_GALLERY = 'gallery';
    const CONTENT_TYPE_PPL = 'ppl';
    const CONTENT_TYPE_XPL = 'xpl';


    public function __construct(array $attributes = [])
    {
        $this->imagePathDetail = $this->commonImgPath . 'detail/';
        $this->imagePathGallery = $this->commonImgPath . 'gallery/';
        $this->imagePathMicro = $this->commonImgPath . 'micro/';
        parent::__construct($attributes);
    }

    public static function getPhotoUrls(string $publicPath): array
    {
        if (!is_dir(public_path($publicPath))) {
            return [];
        }
        $photos = array_values(array_diff(
            scandir(public_path($publicPath)), ['.', '..']
        ));
        return array_map(function ($item) use ($publicPath) {
                return env('APP_URL') . $publicPath . '/' . $item;
            },
            $photos
        );
    }

    public static function getDropzonePhotos(string $publicPath): array
    {
        if (!is_dir(public_path($publicPath))) {
            return [];
        }
        $photos = array_values(array_diff(
            scandir(public_path($publicPath)), ['.', '..']
        ));
        $folder = public_path($publicPath);
        return array_map(function ($item) use ($publicPath, $folder) {
                $tmpObj = new \stdClass();
                $tmpObj->name = $item;
                $tmpObj->url = env('APP_URL') . $publicPath . '/' . $item;
                $tmpObj->size = filesize($folder . '/' . $item);
                return $tmpObj;
            },
            $photos
        );
    }

    public static function getPhotoPath(int $id, $modelClass, string $type): string
    {
        switch ($type) {
            case self::CONTENT_TYPE_GALLERY:
                $path = $modelClass::GALLERY_PATH . $id;
                break;
            case self::CONTENT_TYPE_PPL:
            case self::CONTENT_TYPE_XPL:
                $path = $modelClass::MICRO_PATH . $id . '/' . $type;
                break;
            default:
                $path = '';
        }
        return $path;
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
        return env('APP_URL') . $this->imagePathDetail . $this->photo . '?' . time();
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
        static::deleteImage($this->imagePathDetail . $this->photo);
        $filename = $this->getKey() . '.' . $photo->extension();
        $photo->storeAs($this->imagePathDetail, $filename);
        $this->photo = $filename;
        return $this;
    }

    /**
     * @param UploadedFile[] $pplPhotos
     * @param UploadedFile[] $xplPhotos
     */
    public function uploadMicroscope(array $pplPhotos, array $xplPhotos)
    {
        $pplPath = $this->imagePathMicro . $this->id . '/ppl';
        $xplPath = $this->imagePathMicro . $this->id . '/xpl';
//        Storage::deleteDirectory($pplPath);
//        Storage::deleteDirectory($xplPath);
        // TODO: count($pplPhotos) == 36
        // TODO: flags: плавный переход, 5 или 10 градусов
        if (count($pplPhotos) > 0) {
            self::saveImages2Dir($pplPhotos, $pplPath);
        }
        if (count($xplPhotos) > 0) {
            self::saveImages2Dir($xplPhotos, $xplPath);
        }
    }

    /**
     * Upload microscope PPL or XPL photos
     */
    public static function uploadMicroscopeByType(int $id, $photos, $photosType): bool
    {
        // path like /images/{rocks|minerals|fossils}/micro/{id}/{ppl|xpl}
        $photosPath = static::MICRO_PATH . $id . '/' . $photosType;
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (count($photos) > 0) {
            self::saveImages2Dir($photos, $photosPath);
        }
        return true;
    }


    //TODO: don't delete all photos. Need to add ability to add and remove one photo.

    public static function uploadGallery($id, $photos)
    {
        $path = static::GALLERY_PATH . $id;
//        Storage::deleteDirectory($path);
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (count($photos) > 0) {
            self::saveImages2Dir($photos, $path);
        }
        return true;
    }

    public static function getMicroscopeUrl($id): string
    {
        return '';
    }

    public function getGallery()
    {

    }

    public function remove()
    {
        static::deleteImage($this->imagePathDetail . $this->photo);
        Storage::deleteDirectory($this->imagePathMicro . $this->id);
        Storage::deleteDirectory($this->imagePathGallery . $this->id);
    }

    public static function deleteImage($path)
    {
        if (!empty($path) && file_exists(public_path($path))) {
            Storage::delete($path);
        }
    }

    /**
     * @param UploadedFile[] $items
     * @param string $path
     */
    private static function saveImages2Dir(array $items, string $path)
    {
        self::createDirIfNotExist($path);
        foreach ($items as $item) {
            $item->storeAs($path, $item->getClientOriginalName());
        }
    }

    private static function createDirIfNotExist($dirPath)
    {
        return is_dir($dirPath) || Storage::makeDirectory($dirPath);
    }

}
