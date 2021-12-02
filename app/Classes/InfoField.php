<?php

namespace App\Classes;

class InfoField
{
    private $caption;
    private $value;

    public function __construct($caption, $value)
    {
        $this->caption = $caption;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
