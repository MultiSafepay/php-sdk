<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration\Api\Transactions;

use Exception;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails\CardAuthenticationDetails;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails\CardAuthenticationResult;
use MultiSafepay\Tests\Utils\FixtureLoader;
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
     * Test if getPaymentDetails->getCardAuthenticationResult returns a CardAuthenticationResult instance
     *
     * @return void
     * @throws Exception
     */
    public function testGetPaymentDetailsReturnsCardAuthenticationResult(): void
    {
        $transactionResponse = $this->createTransactionResponseWithCreditCardOrderFixture();
        $paymentDetails = $transactionResponse->getPaymentDetails();
        $this->assertInstanceOf(CardAuthenticationResult::class, $paymentDetails->getCardAuthenticationResult());
    }

    /**
     * Test if getPaymentDetails->getCardAuthenticationDetails returns a CardAuthenticationDetails instance
     *
     * @return void
     * @throws Exception
     */
    public function testGetPaymentDetailsReturnsCardAuthenticationDetails(): void
    {
        $transactionResponse = $this->createTransactionResponseWithCreditCardOrderFixture();
        $paymentDetails = $transactionResponse->getPaymentDetails();
        $this->assertInstanceOf(CardAuthenticationDetails::class, $paymentDetails->getCardAuthenticationDetails());
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

    /**
     * Retrieve a TransactionResponse with the provided credit card order details fixture
     * @return TransactionResponse
     * @throws Exception
     */
    private function createTransactionResponseWithCreditCardOrderFixture(): TransactionResponse
    {
        $data = FixtureLoader::loadFixtureDataById('credit-card-order');
        return new TransactionResponse($data['data']);
    }
}
