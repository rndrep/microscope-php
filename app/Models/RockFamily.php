<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RockFamily extends AbstractDictionary
{
    use HasFactory;

    const ENTITY_CAPTION = 'Семейства пород';
}
