<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api;

use MultiSafepay\Api;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Tests\Fixtures\Order;
use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockClient;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionsTest extends TestCase
{
    use Order;

    /**
     * Test the creation of a transaction
     */
    public function testCreateTransactionWithValidApiKey(): void
    {
        $orderData = $this->createOrder();

        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'order_id' => $orderData['order_id'],
                    'payment_url' => 'https://testpayv2.multisafepay.com/'
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $paymentLink = $multisafepay->transactions()->create($orderData)->getPaymentLink();

        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/', $paymentLink);
    }


    /**
     * Test the return of an Exception when an invalid API key is being used.
     */
    public function testCreateTransactionWithInvalidApiKey(): void
    {
        $multisafepay = new Api('__invalid__', false);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1032);
        $this->expectExceptionMessage('Invalid API key');
        $multisafepay->transactions()->create($this->createOrder());
    }

    /**
     * Test if we can collect the payment data
     */
    public function testGetTransactionWithValidApiKey(): void
    {
        $orderId = (string)time();
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'order_id' => $orderId,
                    'status' => 'completed',
                    'transaction_id' => 4051823,
                    'amount' => 9743
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $transaction = $multisafepay->transactions()->get($orderId);

        $this->assertNull($transaction->getPaymentLink());
        $this->assertSame('completed', $transaction->getData()['status']);
    }

    /**
     * Test the return of an Exception when an invalid order Id is being used.
     */
    public function testGetTransactionWithInvalidOrderId(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            401,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => false,
                'data' => [],
                'error_code' => 1006,
                'error_info' => 'Invalid transaction ID'
            ])
        ));

        $orderId = (string)time();
        $multisafepay = new Api('__invalid__', false, $mockClient);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1006);
        $this->expectExceptionMessage('Invalid transaction ID');
        $multisafepay->transactions()->get($orderId);
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

        $multisafepay = new Api('__valid__', false);
        $multisafepay->transactions()->create($orderData);
    }
}
