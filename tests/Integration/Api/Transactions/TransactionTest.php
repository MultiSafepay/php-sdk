<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Tests\Fixtures\OrderDirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    use OrderDirectFixture;
    use PaymentOptionsFixture;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $requestDirectOrder = $this->createOrderDirectRequestFixture();
        $transaction = new Transaction($requestDirectOrder->getData());

        $data = $transaction->getData();
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
