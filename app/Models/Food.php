<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;
    public $table = 'foods';

    public $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'decimal:0',
        'image' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
