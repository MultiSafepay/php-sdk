<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Client;

use MultiSafepay\Exception\InvalidApiKeyException;

class ApiKey
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * ApiKey constructor.
     * @param string $apiKey
     */
    public function __construct(
        string $apiKey
    ) {
        $this->initApiKey($apiKey);
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    private function initApiKey(string $apiKey)
    {
        if (strlen($apiKey) < 5) {
            throw new InvalidApiKeyException('Invalid API key');
        }

        $this->apiKey = $apiKey;
    }
}
