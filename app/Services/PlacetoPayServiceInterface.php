<?php

namespace App\Services;

interface PlacetoPayServiceInterface
{
    public function payment(array $paymentData);
}
