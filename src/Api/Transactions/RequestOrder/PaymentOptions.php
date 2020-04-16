<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base;

/**
 * Class PaymentOptions
 * @package MultiSafepay\Api\Transactions
 */
class PaymentOptions extends Base\DataObject
{
    /**
     * @param string $notificationUrl
     */
    public function addNotificationUrl(string $notificationUrl)
    {
        $this->addData(['notification_url' => $notificationUrl]);
    }

    /**
     * @param string $redirectUrl
     */
    public function addRedirectUrl(string $redirectUrl)
    {
        $this->addData(['redirect_url' => $redirectUrl]);
    }

    /**
     * @param string $cancelUrl
     */
    public function addCancelUrl(string $cancelUrl)
    {
        $this->addData(['cancel_url' => $cancelUrl]);
    }

    /**
     * @param string $closeWindow
     */
    public function addCloseWindow(string $closeWindow)
    {
        $this->addData(['close_window' => $closeWindow]);
    }
}
