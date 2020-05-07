<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequestInterface;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class TransactionManager
 * @package MultiSafepay\Api
 */
class TransactionManager extends AbstractManager
{
    /**
     * @param OrderRequestInterface $requestOrder
     * @return Transaction
     * @throws ClientExceptionInterface
     */
    public function create(OrderRequestInterface $requestOrder): Transaction
    {
        $response = $this->client->createPostRequest('orders', $requestOrder);
        return new Transaction($response->getResponseData());
    }

    /**
     * Get all data from a transaction.
     * @param string $orderId
     * @return Transaction
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function get(string $orderId): Transaction
    {
        $endpoint = 'orders/' . $orderId;
        $response = $this->client->createGetRequest($endpoint);
        return new Transaction($response->getResponseData());
    }

    /**
     * @param Transaction $transaction
     * @param RefundRequest $requestRefund
     * @return array
     * @throws ClientExceptionInterface
     */
    public function refund(Transaction $transaction, RefundRequest $requestRefund): array
    {
        $response = $this->client->createPostRequest(
            'orders/' . $transaction->getOrderId() . '/refunds',
            $requestRefund
        );

        return $response->getResponseData();
    }
}
