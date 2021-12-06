<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminIndex extends Component
{
    public $title;
    public $hrefCreate;
    public $model;
    public $fields;
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $hrefCreate, $model, $fields, $items)
    {
        $this->title = $title;
        $this->hrefCreate = $hrefCreate;
        $this->model = $model;
        $this->fields = $fields;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-index');
    }
}
