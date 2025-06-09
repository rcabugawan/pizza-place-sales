<?php

namespace App\Enums;

enum PizzaSize: string
{
    case SMALL = 'S';
    case MEDIUM = 'M';
    case LARGE = 'L';
    case EXTRA_LARGE = 'XL';
    case DOUBLE_EXTRA_LARGE = 'XXL';

    public function label(): string
    {
        return match($this) {
            PizzaSize::SMALL => __('Small'),
            PizzaSize::MEDIUM => __('Medium'),
            PizzaSize::LARGE => __('Large'),
            PizzaSize::EXTRA_LARGE => __('Extra Large'),
            PizzaSize::DOUBLE_EXTRA_LARGE => __('Double XL'),
            default => __('Unknown Size'),
        };
    }
}