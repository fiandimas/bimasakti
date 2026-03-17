<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const ORDER_FEE = 2500;
    const COMPANY_CODE = '8834';

    const ORDER_PAID = 'paid';
    const ORDER_PENDING = 'pending';
    const ORDER_EXPIRED = 'expired';

    protected $fillable = [
        'amount',
        'reff',
        'name',
        'phone',
        'code',
        'status',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expired' => 'datetime',
    ];
}
