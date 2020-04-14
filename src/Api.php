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

class Api
{
    /** @var Client */
    private $client;

    /**
     * Api constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     */
    public function __construct(string $apiKey, bool $isProduction, ClientInterface $httpClient = null)
    {
        $this->client = new Client($apiKey, $isProduction, $httpClient);
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
