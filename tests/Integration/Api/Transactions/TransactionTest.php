<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    use GenericOrderRequestFixture;
    use DirectOrderRequestFixture;
    use PaymentOptionsFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use IdealGatewayInfoFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;
    use PluginDetailsFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $orderRequest = $this->createOrderIdealDirectRequestFixture();
        $transaction  = new TransactionResponse($orderRequest->getData());

        $data = $transaction->getData();
        $this->assertArrayHasKey('type', $data, var_export($data, true));
    }

    /**
     * Test if IDEAL doesn't require a shopping cart
     */
    public function testNotRequiresShoppingCart(): void
    {
        $orderRequest = $this->createOrderIdealDirectRequestFixture();
        $this->addPaymentDetails($orderRequest);
        $transaction = new TransactionResponse($orderRequest->getData());

        $this->assertFalse($transaction->requiresShoppingCart());
    }

    /**
     * Test if PAYAFTER does require a shopping cart
     */
    public function testRequiresShoppingCart(): void
    {
        $orderRequest = $this->createGenericOrderRequestFixture();
        $orderRequest->addGatewayCode(GatewayFixture::PAYAFTER);
        $this->addPaymentDetails($orderRequest);
        $transaction = new TransactionResponse($orderRequest->getData());

        $this->assertTrue($transaction->requiresShoppingCart());
    }

    /**
     * Add PaymentDetails to OrderRequest
     *
     * @param OrderRequest $orderRequest
     */
    private function addPaymentDetails(OrderRequest $orderRequest)
    {
        $orderRequest->addData(
            [
                'payment_details' => [
                    "type" => $orderRequest->getGatewayCode(),
                ],
            ]
        );
    }
}
