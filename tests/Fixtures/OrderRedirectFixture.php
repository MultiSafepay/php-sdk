<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect\GatewayInfo\Meta as MetaGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect\Payafter;
use MultiSafepay\Api\Transactions\RequestOrderRedirect;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\ShoppingCart;

/**
 * Trait OrderRedirectFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait OrderRedirectFixture
{
    /**
     * @return RequestOrderRedirect
     */
    public function createIdealOrderRedirectRequestFixture(): RequestOrderRedirect
    {
        return new RequestOrderRedirect(
            (string)time(),
            Money::EUR(20),
            Gateway::IDEAL,
            $this->createPaymentOptionsFixture(),
            new IdealGatewayInfo('0031'),
            new Description('Foobar')
        );
    }

    /**
     * @return RequestOrderRedirect
     */
    public function createPayafterOrderRedirectRequestFixture(): RequestOrderRedirect
    {
        return new Payafter(
            (string)time(),
            Money::EUR(100), // @todo: Make sure this matches with shopping_cart
            Gateway::PAYAFTER,
            $this->createPaymentOptionsFixture(),
            $this->createMetaGatewayInfoFixture(),
            $this->createCustomerDetailsFixture(),
            $this->createCustomerDetailsFixture(),
            $this->createShoppingCartFixture(), // @todo: Make sure tax_table_selector matches with tax_table
            $this->createTaxTableFixture(),
            new Description('Foobar')
        );
    }

    /**
     * @return ShoppingCart
     * @todo Add a test using this empty cart to trigger ApiException 'Empty shopping cart'
     */
    public function getEmptyShoppingCart()
    {
        return new ShoppingCart([]);
    }

    /**
     * @return MetaGatewayInfo
     */
    private function createMetaGatewayInfoFixture()
    {
        return new MetaGatewayInfo(
            new Date('17 december 2001'),
            new BankAccount('0417164300'),
            new PhoneNumber('0208500500'),
            new EmailAddress('example@multisafepay.com')
        );
    }
}
