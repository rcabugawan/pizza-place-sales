<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    public $visible = [
        'order_id',
        'date',
        'time'
    ];

    public $casts = [
        'date' => 'date',
    ];

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }
}
