<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder;

/**
 * Trait OrderRedirectFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait OrderRedirectFixture
{
    /**
     * @return array
     */
    public function createOrderRedirectRequestFixture(): RequestOrder
    {
        $orderId = time();
        $requestOrder = new RequestOrder();
        $requestOrder->addType('redirect');
        $requestOrder->addCustomerDetails($this->createCustomerDetailsFixture());
        $requestOrder->addDescription('Foobar');
        $requestOrder->addMoney(Money::EUR(20));
        $requestOrder->addGateway('ideal');
        $requestOrder->addSecondChance(true);
        $requestOrder->addOrderId($orderId);
        $requestOrder->addPaymentOptions($this->createPaymentOptionsFixture());

        return $requestOrder;
    }
}
