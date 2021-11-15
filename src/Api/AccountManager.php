<?php declare(strict_types=1);
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Account\Account;
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
     * @throws ClientExceptionInterface
     */
    public function get(): Account
    {
        $response = $this->client->createGetRequest(
            'json/me'
        );

        return new Account($response->getResponseData());
    }
}
