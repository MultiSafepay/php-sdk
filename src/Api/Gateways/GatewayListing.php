<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

use MultiSafepay\Exception\InvalidDataInitializationException;

class GatewayListing
{
    /**
     * @var array
     */
    private $gateways;

    /**
     * Transaction constructor.
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $gateways = [];
        if (!empty($data)) {
            foreach ($data as $gatewayData) {
                $gateways[] = new Gateway($gatewayData);
            }
        }
        $this->gateways = $gateways;
    }

    /**
     * @return Gateway[]
     */
    public function getGateways(): array
    {
        return $this->gateways;
    }
}
