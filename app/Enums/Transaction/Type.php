<?php

namespace App\Enums\Transaction;

enum Type: int
{
    case Sell = 1;
    case Buy = 2;

    public function label(): string
    {
        return match($this) {
            Type::Sell => '売却',
            Type::Buy => '購入',
        };
    }
}