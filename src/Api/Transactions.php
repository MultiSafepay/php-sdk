<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Transactions\Transaction;

class Transactions extends Base
{
    /**
     * @param array $body
     * @return Transaction
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws MultiSafepay\Exception\ApiException
     */
    public function create(array $body): Transaction
    {
        $response = $this->client->createPostRequest('orders', $body);
        return new Transaction($response);
    }

    /**
     * Get all data from a transaction.
     * @param string $id
     * @return Transaction
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $id): Transaction
    {
        $endpoint = 'orders/' . $id;
        $response =  $this->client->createGetRequest($endpoint);

        return new Transaction($response);
    }
}
