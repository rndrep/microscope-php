<?php

namespace App\Classes;

use App\View\Input\AbstractField;

class TextareaField extends AbstractField
{

    protected function init()
    {
        $this->viewName = 'admin.inputs.textarea';
        parent::init();
    }

}
