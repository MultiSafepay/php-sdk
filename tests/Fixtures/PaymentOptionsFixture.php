<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use MultiSafepay\Api\Transactions\RequestOrder\PaymentOptions;
use MultiSafepay\ValueObject\Customer;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait PaymentOptionsFixture
{
    /**
     * @return Customer
     */
    public function createPaymentOptionsFixture(): PaymentOptions
    {
        $paymentOptions = new PaymentOptions(
            'http://www.example.com/client/notification?type=notification',
            'http://www.example.com/client/notification?type=redirect',
            'http://www.example.com/client/notification?type=cancel',
            true
        );

        return $paymentOptions;
    }
}
