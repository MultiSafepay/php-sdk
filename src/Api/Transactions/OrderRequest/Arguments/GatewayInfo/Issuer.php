<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class Issuer
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Issuer implements GatewayInfoInterface
{
    /**
     * @var string
     */
    protected $issuerId;

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'issuer_id' => $this->issuerId,
        ];
    }

    /**
     * @param string $issuerId
     * @return GatewayInfoInterface
     */
    public function addIssuerId(string $issuerId)
    {
        $this->issuerId = $issuerId;
        return $this;
    }
}
