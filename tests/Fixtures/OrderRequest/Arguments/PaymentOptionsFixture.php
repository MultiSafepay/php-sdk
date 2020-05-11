<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;

/**
 * Trait PaymentOptionsFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait PaymentOptionsFixture
{
    /**
     * @return PaymentOptions
     */
    public function createPaymentOptionsFixture(): PaymentOptions
    {
        $paymentOptions = (new PaymentOptions())
            ->addNotificationUrl('http://www.example.com/client/notification?type=notification')
            ->addRedirectUrl('http://www.example.com/client/notification?type=redirect')
            ->addCancelUrl('http://www.example.com/client/notification?type=cancel')
            ->addCloseWindow(true);

        return $paymentOptions;
    }
}
