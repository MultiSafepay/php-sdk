<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Client\Client;

/**
 * Class AbstractManager
 * @package MultiSafepay\Api
 */
abstract class AbstractManager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Base constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
