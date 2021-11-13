<?php

namespace App\Models;

class AbstractEntity extends \Illuminate\Database\Eloquent\Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    // Use this for all dictionaries
    /**
     * @param string $class dictionary id (rockType, rockClass, etc.)
     * @return int
     */
    public function getDictionaryPropId(string $class)
    {
        $relation = lcfirst($class);
        if (empty($this->$relation)) {
            return '';
        }
        return $this->$relation->id ?? 0;
    }

    /**
     * @param string $class dictionary name (rockType, rockClass, etc.)
     * @return string
     */
    public function getDictionaryPropName(string $class)
    {
        $relation = lcfirst($class);
        if (empty($this->$relation)) {
            return '';
        }
        return $this->$relation->name ?? '';
    }

}
