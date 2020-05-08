<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

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
     * GoogleAnalytics constructor.
     * @param string $accountId
     */
    public function __construct(string $accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'account' => $this->accountId,
        ];
    }
}
