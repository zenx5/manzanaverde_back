<?php

namespace App\Repositories;

use App\Models\Food;
use App\Repositories\BaseRepository;

class FoodRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'description',
        'price',
        'image'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Food::class;
    }
}
