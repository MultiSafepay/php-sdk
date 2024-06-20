<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\TransactionResponse;
use PHPUnit\Framework\TestCase;

class TransactionResponseTest extends TestCase
{
    /**
     * Test if getGatewayId will return a single gateway ID when only one payment method is used
     *
     * @return void
     */
    public function testGetGatewayIdReturnsSingleGatewayIdWhenOnlyOnePaymentMethodIsUsed(): void
    {
        $transactionResponse = $this->createTransactionResponseWithPaymentMethods([
            ['type' => 'VISA'],
        ]);

        $this->assertEquals('VISA', $transactionResponse->getGatewayId());
    }

    /**
     * Test if getGatewayId will return multiple gateway IDs when multiple payment methods are used
     *
     * @return void
     */
    public function testGetGatewayIdReturnsMultipleGatewayIdsWhenMultiplePaymentMethodsAreUsed(): void
    {
        $transactionResponse = $this->createTransactionResponseWithPaymentMethods([
            ['type' => 'VISA'],
            ['type' => 'MASTERCARD'],
        ]);

        $this->assertEquals('VISA, MASTERCARD', $transactionResponse->getGatewayId());
    }

    /**
     * Test if getGatewayId will return the coupon brand when a coupon payment method is used
     *
     * @return void
     */
    public function testGetGatewayIdReturnsCouponBrandWhenCouponPaymentMethodIsUsed(): void
    {
        $transactionResponse = $this->createTransactionResponseWithPaymentMethods([
            ['type' => 'COUPON', 'coupon_brand' => 'GIFT'],
        ]);

        $this->assertEquals('GIFT', $transactionResponse->getGatewayId());
    }

    /**
     * Test if getGatewayId will return unknown when a coupon payment method is used without a brand
     *
     * @return void
     */
    public function testGetGatewayIdReturnsUnknownWhenCouponPaymentMethodIsUsedWithoutBrand(): void
    {
        $transactionResponse = $this->createTransactionResponseWithPaymentMethods([
            ['type' => 'COUPON'],
        ]);

        $this->assertEquals('unknown', $transactionResponse->getGatewayId());
    }

    /**
     * Retrieve a TransactionResponse with the provided payment methods
     *
     * @param array $paymentMethods
     * @return TransactionResponse
     */
    private function createTransactionResponseWithPaymentMethods(array $paymentMethods): TransactionResponse
    {
        $data = ['payment_methods' => $paymentMethods];
        return new TransactionResponse($data);
    }
}
