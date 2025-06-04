<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

class UnitPrice
{
    /**
     * @var float
     */
    private $unitPrice;

    /**
     * Should be given in full units excluding tax, preferably including 10 decimal at most, e.g. 3.305785124
     *
     * @param float $unitPrice
     */
    public function __construct(float $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return float
     */
    public function get(): float
    {
        return $this->unitPrice;
    }
}
