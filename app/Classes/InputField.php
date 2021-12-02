<?php

namespace App\Classes;

class InputField
{
    private $caption;
    private $prop;
    private $type;
    private $required;
    private $requiredTip;
    private $isDict = false;

    public function __construct($caption, $property, $type, $required = false, $requiredTip = 'Обязательное поле')
    {
        $this->caption = $caption;
        $this->prop = $property;
        $this->type = $type;
        $this->required = $required;
        $this->requiredTip = $requiredTip;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        // TODO: сделать нормально
        return $this->caption . ($this->required ? ' <span class="required-field">*</span>' : '');
    }

    /**
     * @return mixed
     */
    public function getProp()
    {
        if ($this->isDict) {
            return sprintf('getDictionaryPropName(\'%s\')', $this->prop);
        }
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

    public function isDict(): bool
    {
        return $this->isDict;
    }

    public function toggleDict(): self
    {
        $this->isDict = !$this->isDict;
        return $this;
    }
}
