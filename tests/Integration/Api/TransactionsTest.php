<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration\Api;

use Money\Money;
use MultiSafepay\Api;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Tests\Fixtures\Order;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionsTest extends TestCase
{
    use Order;

    /**
     * Test the creation of a transaction
     */
    public function testCreateTransaction(): void
    {
        $orderData = $this->createOrder();

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'order_id' => $orderData['order_id'],
            'payment_url' => 'https://testpayv2.multisafepay.com/'
        ]);

        $transactions = new Api\Transactions($mockClient);
        $transaction = $transactions->create($orderData);

        $this->assertEquals($orderData['order_id'], $transaction->getOrderId());

        $paymentLink = $transaction->getPaymentLink();
        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/', $paymentLink);
    }


    /**
     * Test the return of an Exception when an invalid API key is being used.
     *
     * @todo: Move this to a ClientTest class because it is not related to Transactions
     */
    public function testCreateTransactionWithInvalidApiKey(): void
    {
        $mockClient = MockClient::getInstance('__invalid__');
        $mockClient->mockResponse([], false, 1032, 'Invalid API key');
        $transactions = new Api\Transactions($mockClient);

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1032);
        $this->expectExceptionMessage('Invalid API key');
        $transactions->create($this->createOrder());
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

        $transactions = new Api\Transactions($mockClient);
        $transaction = $transactions->get($orderId);

        $this->assertNull($transaction->getPaymentLink());
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

        $transactions = new Api\Transactions($mockClient);
        $transaction = $transactions->get($fakeOrderId);

        $mockClient->mockResponse([
            'refund_id' => $fakeRefundId,
            'transaction_id' => $fakeTransactionId,
        ]);

        $transactions = new Api\Transactions($mockClient);
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
        $transactions = new Api\Transactions($mockClient);

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1006);
        $this->expectExceptionMessage('Invalid transaction ID');
        $transactions->get('42');
    }

    /**
     * Test if the validation will throw an error if the plugin version is missing
     *
     * @throws ClientExceptionInterface
     */
    public function testValidateVersionWithoutPluginData(): void
    {
        $orderData = $this->createOrder();
        unset($orderData['plugin']);

        $this->expectException(MissingPluginVersionException::class);
        $this->expectExceptionMessage('Plugin version is missing');

        $mockClient = MockClient::getInstance();
        $transactions = new Api\Transactions($mockClient);
        $transactions->create($orderData);
    }
}
