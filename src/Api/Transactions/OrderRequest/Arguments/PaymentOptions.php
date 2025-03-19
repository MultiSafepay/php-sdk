<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class PaymentOptions
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
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
    private $feedUrl = '';

    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var string
     */
    private $notificationMethod = 'POST';

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
     * @param string $notificationUrl
     * @return PaymentOptions
     */
    public function addNotificationUrl(string $notificationUrl): PaymentOptions
    {
        $this->notificationUrl = $notificationUrl;
        return $this;
    }

    /**
     * @param array $settings
     * @return PaymentOptions
     */
    public function addSettings(array $settings): PaymentOptions
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @param string $notificationMethod
     * @return PaymentOptions
     * @throws InvalidArgumentException
     */
    public function addNotificationMethod(string $notificationMethod = 'POST'): PaymentOptions
    {
        if (!in_array($notificationMethod, ['GET', 'POST'])) {
            throw new InvalidArgumentException('Notification method can only be "GET" or "POST"');
        }

        $this->notificationMethod = $notificationMethod;
        return $this;
    }

    /**
     * @param string $feedUrl
     * @return PaymentOptions
     */
    public function addFeedUrl(string $feedUrl): PaymentOptions
    {
        $this->feedUrl = $feedUrl;
        return $this;
    }

    /**
     * @param string $redirectUrl
     * @return PaymentOptions
     */
    public function addRedirectUrl(string $redirectUrl): PaymentOptions
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * @param string $cancelUrl
     * @return PaymentOptions
     */
    public function addCancelUrl(string $cancelUrl): PaymentOptions
    {
        $this->cancelUrl = $cancelUrl;
        return $this;
    }

    /**
     * @param bool $closeWindow
     * @return PaymentOptions
     */
    public function addCloseWindow(bool $closeWindow): PaymentOptions
    {
        $this->closeWindow = $closeWindow;
        return $this;
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
    public function getFeedUrl(): string
    {
        return $this->feedUrl;
    }

    /**
     * @return string
     */
    public function getNotificationMethod(): string
    {
        return $this->notificationMethod;
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
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
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
            'feed_url' => $this->getFeedUrl(),
            'notification_method' => $this->getNotificationMethod(),
            'redirect_url' => $this->getRedirectUrl(),
            'cancel_url' => $this->getCancelUrl(),
            'close_window' => $this->isCloseWindow(),
            'settings' => $this->getSettings(),
        ];
    }
}
