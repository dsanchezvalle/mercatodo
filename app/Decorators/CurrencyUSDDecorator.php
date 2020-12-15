<?php

namespace App\Decorators;

use App\Constants\SupportedCurrencies;
use NumberFormatter;

class CurrencyUSDDecorator implements PriceFormatterContract
{
    private $formatter;

    public function __construct(PriceFormatterContract $formatter)
    {
        $this->formatter = $formatter;
    }

    public function format(float $value): string
    {
        $value = $this->formatter->format($value);
        $numberFormatter = new NumberFormatter(SupportedCurrencies::CURRENCY_USD, NumberFormatter::CURRENCY);

        return $numberFormatter->format($value);
    }
}
