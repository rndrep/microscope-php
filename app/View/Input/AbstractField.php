<?php

namespace App\View\Input;

abstract class AbstractField
{

    protected $caption;
    protected $prop;
    protected $value;
    protected $required;
    protected $requiredTip;
    protected $viewName = '';
    protected $html = '';
    protected $viewVars = [];

    public function __construct($caption, $property, $value = '', $required = false, $requiredTip = 'Обязательное поле')
    {
        $this->caption = $caption;
        $this->prop = $property;
        $this->value = $value;
        $this->required = $required;
        $this->requiredTip = $requiredTip;

        $this->viewVars = [
            'caption' => $this->caption,
            'prop' => $this->prop,
            'value' => $this->value,
            'isRequired' => $this->required,
            'requiredTip' => $this->requiredTip,
        ];
        $this->init();
    }

    protected function init()
    {
        if ($this->viewName) {
            $this->html = view($this->viewName, $this->viewVars)->render();
        }
    }

    public function getHtml()
    {
        return $this->html ?? '';
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

    public function getValue()
    {
        return $this->value;
    }

    public function isRequired(): bool
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
