<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

/**
 * Class GatewayInfo
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfo
{
    /**
     * @var string
     */
    private $issuerId;

    /**
     * GatewayInfo constructor.
     * @param string $issuerId
     */
    public function __construct(string $issuerId)
    {
        $this->issuerId = $issuerId;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'issuer_id' => $this->issuerId,
        ];
    }
}
