<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    public $timestamps = false;

    public $visible = [
        'id',
        'label',
    ];

    public function pizza_types(): BelongsToMany
    {
        return $this->belongsToMany(PizzaType::class, 'pizza_type_ingredients', 'ingredient_id', 'pizza_type_id');
    }
}
