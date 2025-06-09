<?php

namespace App\Enums;

enum PizzaTypeCategory: int
{
    case CLASSIC = 1;
    case CHICKEN = 2;
    case VEGGIE = 3;
    case SUPREME = 4;

    public function label(): string
    {
        return match($this) {
            PizzaTypeCategory::CLASSIC=> __('Classic'),
            PizzaTypeCategory::CHICKEN => __('Chicken'),
            PizzaTypeCategory::VEGGIE => __('Veggie'),
            PizzaTypeCategory::SUPREME => __('Supreme'),
            default => __('Unknown Pizza'),
        };
    }
}