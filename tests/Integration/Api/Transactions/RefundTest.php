<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
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
    use ShoppingCartFixture;
    use PluginDetailsFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $orderRequest = $this->createOrderIdealDirectRequestFixture();
        $orderRequest->addMoney(new Money(10000, 'EUR'));
        $orderRequest->addShoppingCart($this->createShoppingCartFixture());

        $transaction = new TransactionResponse($orderRequest->getData());
        $shoppingCart = $transaction->getShoppingCart();
        $shoppingCartItems = $shoppingCart->getItems();
        $this->assertNotEmpty($shoppingCartItems);

        $checkoutData = new CheckoutData();
        $checkoutData->generateFromShoppingCart($shoppingCart);

        $refundRequest = new RefundRequest();
        $refundRequest->addCheckoutData($checkoutData);
        $data = $refundRequest->getData();

        $this->assertArrayHasKey('checkout_data', $data);
        $checkoutData = $data['checkout_data'];
        $this->assertArrayHasKey('items', $checkoutData);
        $checkouItems = $checkoutData['items'];
        $this->assertNotEmpty($checkouItems);
    }
}
