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
        'size',
        'price',
    ];

    public function pizza_type(): BelongsTo
    {
        return $this->belongsTo(PizzaType::class, 'pizza_type_id', 'pizza_type_id');
    }
}
