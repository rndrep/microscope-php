<?php

namespace App\Models;

use App\Classes\YoutubeUrl;
use App\Helpers\Model as ModelHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class AbstractMediaEntity extends AbstractEntity
{

    protected $imagePathDetail;
    protected $imagePathGallery;
    protected $imagePathMicro;
    protected $commonImgPath; // duplicated logic of path constants (PHOTO_INFO_PATH, MICRO_PATH, GALLERY_PATH)

    protected $guarded = ['photo', 'gallery', 'ppl', 'xpl', 'is_public'];

    const PHOTO_INFO_PATH = '';
    const MICRO_PATH = '';
    const GALLERY_PATH = '';

    const PHOTO_TYPE_INFO = 'info';
    const PHOTO_TYPE_GALLERY = 'gallery';
    const PHOTO_TYPE_PPL = 'ppl';
    const PHOTO_TYPE_XPL = 'xpl';


    public function __construct(array $attributes = [])
    {
        $this->imagePathDetail = $this->commonImgPath . 'detail/';
        $this->imagePathGallery = $this->commonImgPath . 'gallery/';
        $this->imagePathMicro = $this->commonImgPath . 'micro/';
        parent::__construct($attributes);
    }

    public function getVideo()
    {
        return YoutubeUrl::getUrl($this->video);
    }

    public function getPoint()
    {
        return (empty($this->x) || empty($this->y))
            ? ''
            : $this->x . ',' . $this->y;
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

    public static function getDropzonePhotos(string $publicPath, $type): array
    {
        $path = public_path($publicPath);
        if ($type === self::PHOTO_TYPE_INFO) {
            if (!is_file($path)) {
                return [];
            }
            $tmpObj = new \stdClass();
            $tmpObj->name = basename($path);
            $tmpObj->url = env('APP_URL') . $publicPath;
            $tmpObj->size = filesize($path);
            $photos = [$tmpObj];
        } else {
            if (!is_dir($path)) {
                return [];
            }
            $photos = array_values(array_diff(
                scandir($path), ['.', '..']
            ));
            $photos = array_map(function ($item) use ($publicPath, $path) {
                $tmpObj = new \stdClass();
                $tmpObj->name = $item;
                $tmpObj->url = env('APP_URL') . $publicPath . '/' . $item;
                $tmpObj->size = filesize($path . '/' . $item);
                return $tmpObj;
            },
                $photos
            );
        }
        return $photos;
    }

    public static function getPhotoPath(int $id, $modelClass, string $type): string
    {
        switch ($type) {
            case self::PHOTO_TYPE_INFO:
                /** @var AbstractMediaEntity $instance */
                $instance = $modelClass::find($id);
                $path = '';
                if (!empty($instance) && !empty($instance->photo)) {
                    $path = $instance::PHOTO_INFO_PATH . $instance->photo;
                }
                break;
            case self::PHOTO_TYPE_GALLERY:
                $path = $modelClass::GALLERY_PATH . $id;
                break;
            case self::PHOTO_TYPE_PPL:
            case self::PHOTO_TYPE_XPL:
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
            return env('APP_URL') . '/img/no-image.png';
        }
        return env('APP_URL') . $this->imagePathDetail . $this->photo . '?' . time();
    }


    public static function uploadPhoto($instance, $photo)
    {
        if (empty($photo)) {
            return false;
        }
        if (is_array($photo)) {
            $photo = $photo[0];
        }
        static::deleteImage(static::PHOTO_INFO_PATH. $instance->photo);
        $filename = $instance->getKey() . '.' . $photo->extension();
        $photo->storeAs(static::PHOTO_INFO_PATH, $filename);
        $instance->photo = $filename;
        $instance->save();
        return $instance;
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

    public static function getRotationUrl($id): string
    {
        $model = static::class;
        $item = $model::find($id);
        return ($item && !empty($item->model_3d))
            ? route(
                'rotation',
                ['id' => $id, 'type' => ModelHelper::ShortNameByClass($model), 'src' => $item->model_3d]
            )
            : '';
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

    /**
     * @param $path
     * @return bool
     * @throws \Exception
     */
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
