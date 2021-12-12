<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractMediaEntity;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function getPhotos(Request $request)
    {
        //TODO: validate fields
        try {
            /**
             * @var int $id
             * @var AbstractMediaEntity $modelClass
             * @var string $type
             */
                [$id, $modelClass, $type] = $this->getCommonParams($request);
            $this->getModelInstance($modelClass, $id);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return response()->json(
            $modelClass::getDropzonePhotos($modelClass::getPhotoPath($id, $modelClass, $type), $type)
        );
    }

    public function savePhotos(Request $request)
    {
        //TODO: validate fields (especially photo)

        try {
            /**
             * @var int $id
             * @var AbstractMediaEntity $modelClass
             * @var string $type
             */
            [$id, $modelClass, $type] = $this->getCommonParams($request);
            $instance = $this->getModelInstance($modelClass, $id);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        $files = $request->file('file');
        if (empty($files)) {
            return 'no files to save';
        }

        switch ($type) {
            case AbstractMediaEntity::PHOTO_TYPE_INFO:
                $modelClass::uploadPhoto($instance, $files);
                break;
            case AbstractMediaEntity::PHOTO_TYPE_GALLERY:
                $modelClass::uploadGallery($id, $files);
                break;
            case AbstractMediaEntity::PHOTO_TYPE_PPL:
            case AbstractMediaEntity::PHOTO_TYPE_XPL:
                $modelClass::uploadMicroscopeByType($id, $files, $type);
                break;
            default:
        }
        return response('ok', 200);
    }

    public function deletePhoto(Request $request): array
    {
        try {
            /**
             * @var int $id
             * @var AbstractMediaEntity $modelClass
             * @var string $type
             */
            list($id, $modelClass, $type) = $this->getCommonParams($request);
            $instance = $this->getModelInstance($modelClass, $id);
            $filename = $request->query('filename');
            switch ($type) {
                case AbstractMediaEntity::PHOTO_TYPE_INFO:
                    $instance->photo = null;
                    $path = $modelClass::PHOTO_INFO_PATH . $filename;
                    break;
                case AbstractMediaEntity::PHOTO_TYPE_GALLERY:
                    $path = $modelClass::GALLERY_PATH . $id . '/' . $filename;
                    break;
                case AbstractMediaEntity::PHOTO_TYPE_PPL:
                case AbstractMediaEntity::PHOTO_TYPE_XPL:
                    $path = $modelClass::MICRO_PATH . $id . '/' . $type . '/' . $filename;
                    break;
                default:
                    $path = '';
            }
            $modelClass::deleteImage($path);
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
        return ['status' => 'ok'];
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    private function getCommonParams(Request $request): array
    {
        $id = $request->query('id');
        $modelClass = $this->getModelClass($request->query('entity'));
        $type = $this->getType($request->query('type'));
        if (empty($id) || empty($modelClass) || empty($type)) {
            throw new \Exception('id, entity or type is wrong');
        }
        return [$id, $modelClass, $type];
    }

    private function getModelClass($modelName)
    {
        $modelClass = 'App\Models\\' . ucfirst($modelName);
        return class_exists($modelClass) ? $modelClass : false;
    }

    /**
     * @param $modelClass
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    private function getModelInstance($modelClass, $id)
    {
        $instance = $modelClass::find($id);
        if (empty($instance)) {
            throw new \Exception(sprintf(
                'no [%s] with id [%s]',
                class_basename($modelClass),
                $id
            ));
        }
        return $instance;
    }

    private function getType(string $type): ?string
    {
        return in_array($type,
            [
                AbstractMediaEntity::PHOTO_TYPE_INFO,
                AbstractMediaEntity::PHOTO_TYPE_GALLERY,
                AbstractMediaEntity::PHOTO_TYPE_PPL,
                AbstractMediaEntity::PHOTO_TYPE_XPL
            ]
        )
            ? $type
            : null;

    }


}
