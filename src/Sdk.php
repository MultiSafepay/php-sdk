<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay;

use MultiSafepay\Api\CategoryManager;
use MultiSafepay\Api\GatewayManager;
use MultiSafepay\Api\IssuerManager;
use MultiSafepay\Api\TokenManager;
use MultiSafepay\Api\TransactionManager;
use MultiSafepay\Client\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Sdk
 * @package MultiSafepay
 */
class Sdk
{
    /** @var Client */
    private $client;

    /**
     * Api constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     * @param string $locale
     * @param bool $strictMode
     */
    public function __construct(
        string $apiKey,
        bool $isProduction,
        ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        string $locale = 'en_US',
        bool $strictMode = false
    ) {
        $this->client = new Client(
            $apiKey,
            $isProduction,
            $httpClient,
            $requestFactory,
            $streamFactory,
            $locale,
            $strictMode
        );
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
        return new TokenManager($this->client);
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
