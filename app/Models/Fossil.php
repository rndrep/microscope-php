<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fossil extends AbstractMediaEntity
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->imagePathDetail = '/images/fossils/detail/';
        $this->imagePathGallery = '/images/fossils/gallery/';
    }

}
