<?php

namespace PaylandsSDK\Services;

use PaylandsSDK\Traits\Api;

class PaymentOrder
{
    use Api;

    const ENDPOINTS = [
        'create' => '/wallet',
        'generateAddress' => '/wallet/%s/address',
        'getBalance' => '/wallet/%s/balance',
        'transfer' => '/wallet/%s/transfer'
    ];

}