<?php

namespace App\Classes;

class InputField
{
    private $caption;
    private $prop;
    private $type;
    private $required;
    private $requiredTip;

    public function __construct($caption, $field, $type, $required = false, $requiredTip = 'Обязательное поле')
    {
        $this->caption = $caption;
        $this->prop = $field;
        $this->type = $type;
        $this->required = $required;
        $this->requiredTip = $requiredTip;
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
    public function getProp()
    {
        return $this->prop;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return false|mixed
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getRequiredTip(): string
    {
        return $this->requiredTip;
    }

}
