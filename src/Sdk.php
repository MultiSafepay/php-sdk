<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay;

use MultiSafepay\Api\AccountManager;
use MultiSafepay\Api\ApiTokenManager;
use MultiSafepay\Api\CategoryManager;
use MultiSafepay\Api\GatewayManager;
use MultiSafepay\Api\IssuerManager;
use MultiSafepay\Api\PaymentMethodManager;
use MultiSafepay\Api\TokenManager;
use MultiSafepay\Api\TransactionManager;
use MultiSafepay\Api\WalletManager;
use MultiSafepay\Client\Client;
use MultiSafepay\Exception\InvalidApiKeyException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Sdk
 * @package MultiSafepay
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 */
class Sdk
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var TokenManager
     */
    private $tokenManager;

    /**
     * Api constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     * @param string $locale
     * @param bool $strictMode
     * @throws InvalidApiKeyException
     */
    public function __construct(
        string $apiKey,
        bool $isProduction,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        string $locale = 'en_US',
        bool $strictMode = false
    ) {
        $this->client = new Client(
            trim($apiKey),
            $isProduction,
            $httpClient,
            $requestFactory,
            $streamFactory,
            $locale,
            $strictMode
        );

        $this->tokenManager = new TokenManager($this->client);
    }

    /**
     * @return TransactionManager
     */
    public function getTransactionManager(): TransactionManager
    {
        return new TransactionManager($this->client);
    }

    /**
     * @return GatewayManager
     */
    public function getGatewayManager(): GatewayManager
    {
        return new GatewayManager($this->client);
    }

    /**
     * @return PaymentMethodManager
     */
    public function getPaymentMethodManager(): PaymentMethodManager
    {
        return new PaymentMethodManager($this->client);
    }

    /**
     * @return IssuerManager
     */
    public function getIssuerManager(): IssuerManager
    {
        return new IssuerManager($this->client);
    }

    /**
     * @return TokenManager
     */
    public function getTokenManager(): TokenManager
    {
        return $this->tokenManager;
    }

    /**
     * @return ApiTokenManager
     */
    public function getApiTokenManager(): ApiTokenManager
    {
        return new ApiTokenManager($this->client);
    }

    /**
     * @return WalletManager
     */
    public function getWalletManager(): WalletManager
    {
        return new WalletManager($this->client);
    }

    /**
     * @return AccountManager
     */
    public function getAccountManager(): AccountManager
    {
        return new AccountManager($this->client);
    }

    /**
     * @return CategoryManager
     */
    public function getCategoryManager(): CategoryManager
    {
        return new CategoryManager($this->client);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
