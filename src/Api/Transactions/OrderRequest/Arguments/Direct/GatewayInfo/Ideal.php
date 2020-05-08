<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\Direct\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class Ideal
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\Direct\GatewayInfo
 */
class Ideal implements GatewayInfoInterface
{
    /**
     * @var string
     */
    private $issuerId;

    /**
     * Ideal constructor.
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
