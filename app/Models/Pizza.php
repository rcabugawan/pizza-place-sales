<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pizza extends Model
{
    protected $primaryKey = "pizza_id";
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public $visible = [
        'pizza_id',
        'pizza_type',
        'size',
        'price',
    ];

    public function pizzaType(): BelongsTo
    {
        return $this->belongsTo(PizzaType::class, 'pizza_type', 'pizza_type_id');
    }
}
