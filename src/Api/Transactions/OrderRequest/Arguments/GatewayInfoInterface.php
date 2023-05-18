<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

/**
 * Class GatewayInfoInterface
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
interface GatewayInfoInterface
{
    /**
     * @return array
     */
    public function getData(): array;
}
