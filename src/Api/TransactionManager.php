<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\Transactions\OrderRequestInterface;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\TransactionResponse as Transaction;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Api\Transactions\UpdateRequest;
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
        $context = ['order_id' => $orderId];
        $response = $this->client->createGetRequest($endpoint, [], $context);
        return new Transaction($response->getResponseData());
    }

    /**
     * @param string $orderId
     * @param UpdateRequest $updateRequest
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function update(string $orderId, UpdateRequest $updateRequest): Response
    {
        $context = ['request_body' => $updateRequest->getData()];
        $response = $this->client->createPatchRequest(
            'orders/' . $orderId,
            $updateRequest,
            $context
        );

        return $response;
    }

    /**
     * @param Transaction $transaction
     * @param RefundRequest $requestRefund
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function refund(Transaction $transaction, RefundRequest $requestRefund): Response
    {
        $orderId = $transaction->getOrderId();
        $context = ['transaction' => $transaction->getData()];

        $response = $this->client->createPostRequest(
            'orders/' . $orderId . '/refunds',
            $requestRefund,
            $context
        );

        return $response;
    }

    /**
     * @param Transaction $transaction
     * @param string $merchantItemId
     * @param int $quantity Set to 0 to refund all items
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function refundByItem(Transaction $transaction, string $merchantItemId, int $quantity = 0): Response
    {
        $requestRefund = $this->createRefundRequest($transaction);
        $requestRefund->getCheckoutData()->refundByMerchantItemId($merchantItemId, $quantity);
        return $this->refund($transaction, $requestRefund);
    }

    /**
     * @param Transaction $transaction
     * @return RefundRequest
     */
    public function createRefundRequest(Transaction $transaction): RefundRequest
    {
        $checkoutData = new CheckoutData();
        $checkoutData->generateFromShoppingCart($transaction->getShoppingCart());

        $requestRefund = new RefundRequest();
        $requestRefund->addCheckoutData($checkoutData);

        return $requestRefund;
    }
}
