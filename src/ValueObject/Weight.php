<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

/**
 * Class Weight
 * @package MultiSafepay\ValueObject
 */
class Weight
{
    /**
     * @var string
     */
    private $unit;

    /**
     * @var float|int|string
     */
    private $quantity;

    /**
     * Weight constructor.
     * @param string $unit
     * @param float $quantity
     */
    public function __construct(string $unit, $quantity)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @return float|int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
