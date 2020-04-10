<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api;
use MultiSafepay\Api\Base;
use MultiSafepay\Client;
use MultiSafepay\Exception\ApiException;

class Transaction extends Base
{
    /** @var array */
    private $data;

    /**
     * Transaction constructor.
     * @param array $transaction
     */
    public function __construct(array $transaction, Client $client)
    {
        parent::__construct($client);
        $this->data = $transaction;
    }

    /**
     * @return array
     */
    public function getData():array
    {
        return $this->data['data'];
    }

    /**
     * @return string|null
     */
    public function getPaymentLink(): ?string
    {
        if (!isset($this->getData()['payment_url'])) {
            return null;
        }
        return $this->getData()['payment_url'];
    }

    /**
     * @param float $amount
     * @param string|null $description
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws ApiException
     */
    public function refund(float $amount, ?string $description = null): array
    {
        $refundData = [
            'amount' => $amount * 100,
            'currency' => $this->getData()['currency'],
            'description' => $description
        ];

        $response = $this->client->createPostRequest(
            'orders/' . $this->getData()['order_id'] . '/refunds',
            $refundData
        );

        return $response['data'];
    }
}
