<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_pay_status',
        'note',
        'user_id',
        'order_id',
        'status',
        'email',
        'address',
        'name',
        'phone_number'
    ];
}
