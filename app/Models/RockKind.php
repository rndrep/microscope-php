<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RockKind extends AbstractDictionary
{
    use HasFactory;

    const ENTITY_CAPTION = 'Виды пород';

}
