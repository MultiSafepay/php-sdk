<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Client;

class Transactions
{
    /** @var string */
    private $apiKey;
    /** @var bool */
    private $isProduction;

    /**
     * Transaction constructor.
     * @param string $apiKey
     * @param bool $isProduction
     */
    public function __construct(string $apiKey, bool $isProduction)
    {
        $this->apiKey = $apiKey;
        $this->isProduction = $isProduction;
    }


    /**
     * @param array $body
     * @return Transaction
     * @throws \Http\Client\Exception
     * @throws \MultiSafepay\Exception\ApiException
     */
    public function create(array $body): Transaction
    {
        $client = new Client($this->apiKey, $this->isProduction);
        $response = $client->createPostRequest('orders', $body);

        return new Transaction($response);
    }
}
