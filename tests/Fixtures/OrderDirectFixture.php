<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder;

/**
 * Trait OrderDirectFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait OrderDirectFixture
{
    /**
     * @return array
     */
    public function createOrderDirectRequestFixture(): RequestOrder
    {
        $gatewayInfo = [
            'birthday' => '1980-01-30',
            'bank_account' => '0417164300',
            'phone' => '0208500500',
            'email' => 'example@multisafepay.com'
        ];

        $orderId = time();
        $requestOrder = new RequestOrder();
        $requestOrder->addType('direct');
        $requestOrder->addCustomerDetails($this->createCustomerDetailsFixture());
        $requestOrder->addDescription('Foobar');
        $requestOrder->addMoney(Money::EUR(20));
        $requestOrder->addGateway('ideal');
        $requestOrder->addGatewayInfo($gatewayInfo);
        $requestOrder->addOrderId($orderId);
        $requestOrder->addPaymentOptions($this->createPaymentOptionsFixture());

        return $requestOrder;
    }
}
