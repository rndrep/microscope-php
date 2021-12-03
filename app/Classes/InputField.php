<?php

namespace App\Classes;

use App\View\Input\AbstractField;

class InputField extends AbstractField
{

    protected $type;
//    private $isDict = false;

    public function __construct($caption, $property, $type, $required = false, $requiredTip = 'Обязательное поле')
    {
        $this->type = $type;
        parent::__construct($caption, $property, $required, $requiredTip);
    }

    protected function init()
    {
        $this->viewName = 'admin.inputs.input';
        $this->viewVars['type'] = $this->type;
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


//    methods maybe for dropdown
//
//    public function isDict(): bool
//    {
//        return $this->isDict;
//    }
//
//    public function toggleDict(): self
//    {
//        $this->isDict = !$this->isDict;
//        return $this;
//    }
}
