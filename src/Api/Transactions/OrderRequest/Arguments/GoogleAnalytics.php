<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class GoogleAnalytics
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class GoogleAnalytics
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @param string $accountId
     * @return GoogleAnalytics
     */
    public function addAccountId(string $accountId): GoogleAnalytics
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->validate();

        return [
            'account' => $this->accountId,
        ];
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (empty($this->accountId)) {
            throw new InvalidArgumentException('Account ID can not be empty');
        }

        return true;
    }
}
