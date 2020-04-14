<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration\Api;

use Money\Money;
use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\TransactionManager;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\Order;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionManagerTest extends TestCase
{
    use Order;

    /**
     * Test the creation of a transaction
     * @throws ClientExceptionInterface
     */
    public function testCreateTransaction(): void
    {
        $orderData = $this->createOrder();

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'order_id' => $orderData['order_id'],
            'payment_url' => 'https://testpayv2.multisafepay.com/'
        ]);

        $transactions = new TransactionManager($mockClient);
        $requestBody = new RequestBody($orderData);
        $transaction = $transactions->create($requestBody);

        $this->assertEquals($orderData['order_id'], $transaction->getOrderId());

        $paymentLink = $transaction->getPaymentLink();
        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/', $paymentLink);
    }

    /**
     * Test if we can collect the payment data
     * @throws ClientExceptionInterface
     */
    public function testGetTransactionWithValidApiKey(): void
    {
        $orderId = (string)time();

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'order_id' => $orderId,
            'status' => 'completed',
            'transaction_id' => 4051823,
            'refund_id' => 405223823,
            'amount' => 9743
        ]);

        $transactions = new TransactionManager($mockClient);
        $transaction = $transactions->get($orderId);

        $this->assertEmpty($transaction->getPaymentLink());
        $this->assertSame('completed', $transaction->getData()['status']);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testRefund(): void
    {
        $fakeOrderId = (string)time();
        $fakeTransactionId = 4051824;
        $fakeRefundId = 4059285;

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'order_id' => $fakeOrderId,
            'status' => 'completed',
            'transaction_id' => $fakeTransactionId,
            'currency' => 'EUR',
            'amount' => 10000
        ]);

        $transactions = new TransactionManager($mockClient);
        $transaction = $transactions->get($fakeOrderId);

        $mockClient->mockResponse([
            'refund_id' => $fakeRefundId,
            'transaction_id' => $fakeTransactionId,
        ]);

        $transactions = new TransactionManager($mockClient);
        $refund = $transactions->refund($transaction, Money::EUR(50));

        $this->assertArrayHasKey('refund_id', $refund, var_export($refund, true));
        $this->assertEquals($fakeRefundId, $refund['refund_id'], var_export($refund, true));
        $this->assertEquals($fakeTransactionId, $transaction->getData()['transaction_id']);
        $this->assertEquals($fakeTransactionId, $refund['transaction_id']);
    }

    /**
     * Test the return of an Exception when an invalid order Id is being used.
     * @throws ClientExceptionInterface
     */
    public function testGetTransactionWithInvalidOrderId(): void
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([], false, 1006, 'Invalid transaction ID');
        $transactions = new TransactionManager($mockClient);

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1006);
        $this->expectExceptionMessage('Invalid transaction ID');
        $transactions->get('42');
    }
}
