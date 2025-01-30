<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

/**
 * Class Percentage
 * @package MultiSafepay\ValueObject
 */
class Percentage
{
    /**
     * @var float
     */
    private $percentage;

    /**
     * Percentage constructor.
     *
     * @param float $percentage
     * percentage value 10% = 10
     */
    public function __construct(float $percentage)
    {
        if ($percentage < 0) {
            throw new \InvalidArgumentException('Percentage value must be greater than or equal to 0');
        }

        if ($percentage > 100) {
            throw new \InvalidArgumentException('Percentage value must be less than or equal to 100');
        }

        $this->percentage = $percentage;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->percentage;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->percentage . '%';
    }
}
