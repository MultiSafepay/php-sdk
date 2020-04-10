<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Model\Version;
use Psr\Http\Client\ClientExceptionInterface;

class Transactions extends Base
{
    /**
     * @param array $body
     * @return Transaction
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function create(array $body): Transaction
    {
        $this->validate($body);
        $body = Version::append($body);

        $response = $this->client->createPostRequest('orders', $body);
        return new Transaction($response, $this->client);
    }

    /**
     * Get all data from a transaction.
     * @param string $orderId
     * @return Transaction
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \MultiSafepay\Exception\ApiException
     */
    public function get(string $orderId): Transaction
    {
        $endpoint = 'orders/' . $orderId;
        $response =  $this->client->createGetRequest($endpoint);

        return new Transaction($response, $this->client);
    }

    /**
     * @param $body
     */
    private function validate($body): void
    {
        if (!isset($body['plugin']['plugin_version'])) {
            throw new MissingPluginVersionException();
        }
    }
}
