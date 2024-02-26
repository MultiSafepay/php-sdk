<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Account\Account;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class AccountManager
 *
 * @package MultiSafepay\Api
 */
class AccountManager extends AbstractManager
{
    /**
     * @return Account
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function get(): Account
    {
        $response = $this->client->createGetRequest(
            'json/me'
        );

        return new Account($response->getResponseData());
    }
}
