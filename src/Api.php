<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay;

use MultiSafepay\Api\Transactions;

class Api
{
    /** @var Client */
    private $client;

    /**
     * Api constructor.
     * @param string $apiKey
     * @param bool $isProduction
     */
    public function __construct(string $apiKey, bool $isProduction = true)
    {
        $this->client = new Client($apiKey, $isProduction);
    }

    /**
     * @return Transactions
     */
    public function transactions(): Transactions
    {
        return new Transactions($this->client);
    }
}
