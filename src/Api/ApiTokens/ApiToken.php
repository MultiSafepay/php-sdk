<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\ApiTokens;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class ApiToken
 *
 * @package MultiSafepay\Api\ApiTokens
 */
class ApiToken
{
    /**
     * @var string
     */
    private $apiToken;

    /**
     * ApiToken constructor.
     *
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->apiToken = $data['api_token'];
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    /**
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): void
    {
        if (!isset($data['api_token'])) {
            throw new InvalidDataInitializationException('No Api Token');
        }
    }
}
