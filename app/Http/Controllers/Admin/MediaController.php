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
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $modelClass::getPhotoUrls($modelClass::getPhotoPath($id, $modelClass, $type));

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
            $this->getModelInstance($modelClass, $id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        $files = $request->file('files');
        if (empty($files)) {
            return 'no files to save';
        }

        switch ($type) {
            case AbstractMediaEntity::CONTENT_TYPE_GALLERY:
                // upload gallery
                break;
            case AbstractMediaEntity::CONTENT_TYPE_PPL:
            case AbstractMediaEntity::CONTENT_TYPE_XPL:
                $modelClass::uploadMicroscopeByType($id, $files, $type);
                break;
            default:
        }

    }

    public function deletePhoto(Request $request)
    {
        //TODO: implement deleting
        try {
            list($id, $entity, $type) = $this->getCommonParams($request);

        } catch (\Exception $exception) {
        }
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
                AbstractMediaEntity::CONTENT_TYPE_GALLERY,
                AbstractMediaEntity::CONTENT_TYPE_PPL,
                AbstractMediaEntity::CONTENT_TYPE_XPL
            ]
        )
            ? $type
            : null;

    }


}
