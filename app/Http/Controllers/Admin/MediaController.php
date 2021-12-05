<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbstractMediaEntity;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    const MEDIA_TYPES = ['gallery', 'ppl', 'xpl'];

    public function getPhotos(Request $request)
    {
        //TODO: validate fields
        /**
         * @var int $id
         * @var AbstractMediaEntity $modelClass
         * @var string $type
         */
        [$id, $modelClass, $type] = $this->getParams($request);
        if (empty($id) || empty($modelClass) || empty($type)) {
            return 'id, entity or type is wrong';
        }

        /** @var AbstractMediaEntity $model */
        $model = $modelClass::find($id);
        if (empty($model)) {
            return sprintf(
                'no [%s] with id [%s]',
                class_basename($modelClass),
                $id
            );
        }
        $path = '';
        switch ($type) {
            case 'gallery':
                $path = $modelClass::GALLERY_PATH . $id;
                break;
            case 'ppl':
            case 'xpl':
                $path = $modelClass::MICRO_PATH . $id . '/' . $type;
        }

        return $modelClass::getPhotoPaths($path);

    }

    public function savePhotos(Request $request)
    {
        list($id, $entity, $type) = $this->getParams($request);

    }

    private function savePhoto()
    {

    }

    public function deletePhoto(Request $request)
    {
        list($id, $entity, $type) = $this->getParams($request);

    }

    private function getParams(Request $request)
    {
        $id = $request->query('id');
        $modelClass = $this->getModelClass($request->query('entity'));
        $type = $this->getType($request->query('type'));
        return [$id, $modelClass, $type];
    }

    private function getModelClass($entity)
    {
        $modelClass = 'App\Models\\' . ucfirst($entity);
        return class_exists($modelClass) ? $modelClass : false;
    }

    private function getType($type)
    {
        return in_array($type, self::MEDIA_TYPES)
            ? $type
            : false;

    }

}
