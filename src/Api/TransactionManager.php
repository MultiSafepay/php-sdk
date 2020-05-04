<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use Money\Money;
use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrderInterface;
use MultiSafepay\Api\Transactions\RequestRefund;
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
     * @param RequestOrderInterface $requestOrder
     * @return Transaction
     * @throws ClientExceptionInterface
     */
    public function create(RequestOrderInterface $requestOrder): Transaction
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
     * @param RequestRefund $requestRefund
     * @return array
     * @throws ClientExceptionInterface
     */
    public function refund(Transaction $transaction, RequestRefund $requestRefund): array
    {
        $response = $this->client->createPostRequest(
            'orders/' . $transaction->getOrderId() . '/refunds',
            $requestRefund
        );

        return $response->getResponseData();
    }
}
