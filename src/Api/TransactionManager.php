<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\Pager\Pager;
use MultiSafepay\Api\Transactions\CaptureRequest;
use MultiSafepay\Api\Transactions\OrderRequestInterface;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Api\Transactions\TransactionListing;
use MultiSafepay\Api\Transactions\TransactionResponse as Transaction;
use MultiSafepay\Api\Transactions\UpdateRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class TransactionManager
 *
 * @package MultiSafepay\Api
 */
class TransactionManager extends AbstractManager
{
    private const ALLOWED_OPTIONS = [
        'site_id' => '',
        'financial_status' => '',
        'status' => '',
        'payment_method' => '',
        'type' => '',
        'created_until' => '',
        'created_from' => '',
        'completed_until' => '',
        'completed_from' => '',
        'debit_credit' => '',
        'after' => '',
        'before' => '',
        'limit' => '',
    ];

    /**
     * @param OrderRequestInterface $requestOrder
     * @return Transaction
     * @throws ClientExceptionInterface|ApiException
     */
    public function create(OrderRequestInterface $requestOrder): Transaction
    {
        $response = $this->client->createPostRequest('json/orders', $requestOrder);

        return new Transaction($response->getResponseData());
    }

    /**
     * Get all data from a transaction.
     *
     * @param string $orderId
     * @return Transaction
     * @throws ClientExceptionInterface|ApiException
     */
    public function get(string $orderId): Transaction
    {
        $endpoint = 'json/orders/' . $orderId;
        $context = ['order_id' => $orderId];
        $response = $this->client->createGetRequest($endpoint, [], $context);

        return new Transaction($response->getResponseData());
    }

    /**
     * @param array $options
     * @return TransactionListing
     * @throws ClientExceptionInterface|ApiException
     */
    public function getTransactions(array $options = []): TransactionListing
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);

        $response = $this->client->createGetRequest('json/transactions', $options);
        return new TransactionListing($response->getResponseData(), $response->getPager());
    }

    /**
     * @param string $orderId
     * @param UpdateRequest $updateRequest
     * @return Response
     * @throws ClientExceptionInterface|ApiException
     */
    public function update(string $orderId, UpdateRequest $updateRequest): Response
    {
        return $this->client->createPatchRequest(
            'json/orders/' . $orderId,
            $updateRequest,
            ['request_body' => $updateRequest->getData()]
        );
    }

    /**
     * @param string $orderId
     * @param CaptureRequest $captureRequest
     * @return Response
     * @throws ClientExceptionInterface|ApiException
     */
    public function capture(string $orderId, CaptureRequest $captureRequest): Response
    {
        return $this->client->createPostRequest(
            'json/orders/' . $orderId . '/capture',
            $captureRequest,
            ['request_body' => $captureRequest->getData()]
        );
    }

    /**
     * @param string $orderId
     * @param CaptureRequest $captureRequest
     * @return Response
     * @throws ClientExceptionInterface|ApiException
     */
    public function captureReservationCancel(string $orderId, CaptureRequest $captureRequest): Response
    {
        return $this->client->createPatchRequest(
            'json/capture/' . $orderId,
            $captureRequest,
            ['request_body' => $captureRequest->getData()]
        );
    }

    /**
     * @param Transaction $transaction
     * @param RefundRequest $requestRefund
     * @param string|null $orderId Use this parameter for refunding any child invoices, for example: manual capture
     *                             child invoices
     * @return Response
     * @throws ClientExceptionInterface|ApiException
     */
    public function refund(Transaction $transaction, RefundRequest $requestRefund, ?string $orderId = null): Response
    {
        return $this->client->createPostRequest(
            'json/orders/' . ($orderId ?: $transaction->getOrderId()) . '/refunds',
            $requestRefund,
            ['transaction' => $transaction->getData()]
        );
    }

    /**
     * @param Transaction $transaction
     * @param string $merchantItemId
     * @param int $quantity Set to 0 to refund all items
     * @return Response
     * @throws ClientExceptionInterface|InvalidArgumentException|ApiException
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
     * @throws InvalidArgumentException
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
