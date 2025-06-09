<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PizzaType extends Model
{
    protected $primaryKey = 'pizza_type_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public $visible = [
        'pizza_type_id',
        'name',
        'category',
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_type_ingredients', 'pizza_type_id', 'ingredient_id');
    }

    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class, 'pizza_type_id');
    }
}

