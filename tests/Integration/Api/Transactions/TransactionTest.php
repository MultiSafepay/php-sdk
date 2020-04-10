<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Tests\Integration\MockClient;
use MultiSafepay\Tests\Fixtures\Order;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionTest extends TestCase
{
    use Order;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $orderData = $this->createOrder();
        $transaction = new Transaction($orderData, MockClient::getInstance());

        $data = $transaction->getOrderData();
        $this->assertArrayHasKey('type', $data, var_export($data, true));
    }

    /**
     * @return MockClient
     */
    private function getMockedClientWithOrderResponse(int $orderId): MockClient
    {
        $client = MockClient::getInstance();
        $client->mockResponse([
            'order_id' => $orderId,
            'payment_url' => 'https://testpayv2.multisafepay.com/'
        ]);

        return $client;
    }

    /**
     * @return MockClient
     */
    private function getMockedClientWithRefundResponse(int $orderId): MockClient
    {
        $client = MockClient::getInstance();
        $client->mockResponse([
            'transaction_id' => 42,
            'refund_id' => 42,
        ]);

        return $client;
    }
}
