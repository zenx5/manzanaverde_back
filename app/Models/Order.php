<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public $table = 'orders';

    public $fillable = [
        'total'
    ];

    protected $casts = [
        'total' => 'decimal:0'
    ];

    public static array $rules = [
        'total' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
