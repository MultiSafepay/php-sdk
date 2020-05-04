<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Arguments;

use MultiSafepay\Api\Base;

/**
 * Class PaymentOptions
 * @package MultiSafepay\Api\Transactions\RequestOrder\Arguments
 */
class PaymentOptions
{
    /**
     * @var string
     */
    private $notificationUrl = '';

    /**
     * @var string
     */
    private $redirectUrl = '';

    /**
     * @var string
     */
    private $cancelUrl = '';

    /**
     * @var bool
     */
    private $closeWindow = true;

    /**
     * PaymentOptions constructor.
     * @param string $notificationUrl
     * @param string $redirectUrl
     * @param string $cancelUrl
     * @param bool $closeWindow
     */
    public function __construct(
        string $notificationUrl,
        string $redirectUrl,
        string $cancelUrl,
        bool $closeWindow
    ) {
        $this->notificationUrl = $notificationUrl;
        $this->redirectUrl = $redirectUrl;
        $this->cancelUrl = $cancelUrl;
        $this->closeWindow = $closeWindow;
    }

    /**
     * @return string
     */
    public function getNotificationUrl(): string
    {
        return $this->notificationUrl;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    /**
     * @return bool
     */
    public function isCloseWindow(): bool
    {
        return $this->closeWindow;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'notification_url' => $this->getNotificationUrl(),
            'redirect_url' => $this->getRedirectUrl(),
            'cancel_url' => $this->getCancelUrl(),
            'close_window' => $this->isCloseWindow()
        ];
    }
}
