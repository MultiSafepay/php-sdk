<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class Ideal
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Ideal implements GatewayInfoInterface
{
    /**
     * @var string
     */
    private $issuerId;

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
     * @return Ideal
     */
    public function addIssuerId(string $issuerId): Ideal
    {
        $this->issuerId = $issuerId;
        return $this;
    }
}
