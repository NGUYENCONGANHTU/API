<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'images',
        'price',
        'category_id',
        'trademark_id',
        'sale_price',
        'is_view',
        'is_purchases',
        'description',
        'status',
        'type',
        'star',
        'heart'
    ];
}
