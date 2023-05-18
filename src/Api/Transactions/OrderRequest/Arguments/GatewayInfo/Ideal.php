<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

/**
 * Class Ideal
 *
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 * @deprecated since version 5.6.0. Will be removed in version 7.0.0.
 * @see Issuer for it's replacement
 */
class Ideal extends Issuer
{

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
