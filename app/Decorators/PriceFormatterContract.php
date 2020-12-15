<?php

namespace App\Decorators;

interface PriceFormatterContract
{
    public function format(float $value): string;
}
