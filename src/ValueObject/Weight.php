<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
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
     * @var int
     */
    private $quantity;

    /**
     * Weight constructor.
     * @param string $unit
     * @param int $quantity
     */
    public function __construct(string $unit, int $quantity)
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
