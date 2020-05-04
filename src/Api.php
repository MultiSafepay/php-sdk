<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay;

use MultiSafepay\Api\GatewayManager;
use MultiSafepay\Api\IssuerManager;
use MultiSafepay\Api\TransactionManager;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Api
 * @package MultiSafepay
 */
class Api
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
     */
    public function __construct(
        string $apiKey,
        bool $isProduction,
        ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        string $locale = 'en'
    ) {
        $this->client = new Client($apiKey, $isProduction, $httpClient, $requestFactory, $streamFactory, $locale);
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
}
