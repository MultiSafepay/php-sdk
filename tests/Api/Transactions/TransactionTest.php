<?php
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Transactions;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use MultiSafepay\Api;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{

    /**
     * Test if we can refund an order
     */
    public function testRefund(): void
    {
        $orderId = (string)time();
        $transactionId = 4051824;
        $refundId = 4059285;

        // Setup Responses
        $mockClient = new MockClient();
        $getResponse = new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'order_id' => $orderId,
                    'status' => 'completed',
                    'transaction_id' => $transactionId,
                    'currency' => 'EUR',
                    'amount' => 10000
                ]
            ])
        );

        $refundResponse = new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'refund_id' => $refundId,
                    'transaction_id' => $transactionId,
                ]
            ])
        );
        $mockClient->addResponse($getResponse);
        $mockClient->addResponse($refundResponse);

        $multisafepay = new Api(getenv('API_KEY'), false, $mockClient);
        $transaction = $multisafepay->transactions()->get($orderId);
        $refund = $transaction->refund(50);
        $this->assertEquals($refundId, $refund['refund_id']);
        $this->assertEquals($transactionId, $transaction->getData()['transaction_id']);
        $this->assertEquals($transactionId, $refund['transaction_id']);
    }
}
