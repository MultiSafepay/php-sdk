<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Arguments;

/**
 * Class GatewayInfoInterface
 * @package MultiSafepay\Api\Transactions\RequestOrder\Arguments
 */
interface GatewayInfoInterface
{
    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return array
     */
    public function getCompatibleGateways(): array;

    /**
     * @return array
     */
    public function getCompatibleTypes(): array;
}
