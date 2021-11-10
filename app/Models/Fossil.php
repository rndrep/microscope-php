<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fossil extends AbstractMediaEntity
{
    use HasFactory;

    const SIMPLE_INPUT_FIELDS = [
        'Название' => 'name',
        'Описание' => 'description',
        'Видео' => 'video',
        'Типы беспозвоночных животных' => 'invertebrates',
        'Руководящие формы' => 'index_fossils',
    ];

    public function __construct(array $attributes = [])
    {
        $this->commonImgPath = '/images/fossils/';
//        $this->guarded = array_merge($this->guarded, []);
        parent::__construct($attributes);
    }

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        parent::remove();
        $this->deleteRelatedRocks();
        $this->delete();
    }

    private function deleteRelatedRocks()
    {
        Rock_Fossil::where('fossil_id', $this->id)->delete();
    }

    public static function getOptionalProps(): array
    {
        return ['description'];
    }

    public function rocks()
    {
        return $this->belongsToMany(
            Rock::class,
            'rock__fossils',
            'fossil_id',
            'rock_id'
        );
    }


}
