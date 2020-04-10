<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

class Gateways
{
    /** @var array */
    private $data;

    /**
     * Transaction constructor.
     * @param array $gateways
     */
    public function __construct(array $gateways)
    {
        $this->data = $gateways;
    }

    /**
     * @return array
     */
    public function getData():array
    {
        return $this->data['data'];
    }
}
