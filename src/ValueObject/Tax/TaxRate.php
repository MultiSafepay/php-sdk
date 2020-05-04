<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Tax;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Country;

/**
 * Class TaxRate
 * @package MultiSafepay\ValueObject\Tax
 */
class TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $postcode;

    /**
     * TaxRate constructor.
     * @param float $rate
     * @param Country|null $country
     * @param string $state
     * @param string $postcode
     */
    public function __construct(
        float $rate,
        ?Country $country = null,
        string $state = '',
        string $postcode = ''
    ) {
        $this->setRate($rate);
        $this->country = $country;
        $this->state = $state;
        $this->postcode = $postcode;
    }

    /**
     * @param float $rate
     */
    private function setRate(float $rate)
    {
        if (($rate > 0 && $rate < 1) || $rate > 100) {
            throw new InvalidArgumentException('Rate is supposed to be a number between 1 and 100 (or just 0)');
        }

        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }
}
