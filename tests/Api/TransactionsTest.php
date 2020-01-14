<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api;

use MultiSafepay\Api;
use MultiSafepay\Exception\ApiException;
use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase
{
    /**
     * Test the creation of a transaction
     */
    public function testCreateTransactionWithValidData()
    {
        $orderData = [
            'type' => 'redirect',
            'order_id' => time(),
            'currency' => 'EUR',
            'amount' => 1,
            'description' => 'lorem ipsum'
        ];

        $multiSafepay = new Api(getenv('API_KEY'), false);
        $paymentLink = $multiSafepay->transactions()->create($orderData)->getPaymentLink();

        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/connect/', $paymentLink);
    }

    /**
     * Test the return of an Exception when an invalid API key is being used.
     */
    public function testCreateTransactionWithInvalidApiKey()
    {
        $orderData = [
            'type' => 'redirect',
            'order_id' => time(),
            'currency' => 'EUR',
            'amount' => 1,
            'description' => 'lorem ipsum'
        ];

        $multiSafepay = new Api('1234abCd', false);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1032);
        $this->expectExceptionMessage('Invalid API key');
        $multiSafepay->transactions()->create($orderData);
    }
}
