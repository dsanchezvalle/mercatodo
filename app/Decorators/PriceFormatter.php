<?php

namespace App\Decorators;

final class PriceFormatter implements PriceFormatterContract
{
    /**
     * @param float $price
     * @return string
     */
    public function format(float $price): string
    {
        return (string) $price;
    }
}
