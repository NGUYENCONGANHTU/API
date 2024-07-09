<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'product_name',
        'product_attribute_id',
        'cart_id',
        'quantity',
        'total',
        'status',
        'order_pay_status',
        'order_status'
    ];
}
