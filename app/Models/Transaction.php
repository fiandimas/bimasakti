<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    const ORDER_PAID = 'paid';

    protected $fillable = [
        'amount',
        'reff',
        'name',
        'phone',
        'code',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expired' => 'datetime',
    ];
}
