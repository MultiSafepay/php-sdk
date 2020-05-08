<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Country;

/**
 * Class TaxRate
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable
 */
class TaxRate
{
    /**
     * @var float
     */
    private $rate = 0;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var string
     */
    private $state = '';

    /**
     * @var string
     */
    private $postcode = '';

    /**
     * @param float $rate
     * @return TaxRate
     */
    public function addRate(float $rate): TaxRate
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @param Country $country
     * @return TaxRate
     */
    public function addCountry(Country $country): TaxRate
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param string $state
     * @return TaxRate
     */
    public function addState(string $state): TaxRate
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $postcode
     * @return TaxRate
     */
    public function addPostcode(string $postcode): TaxRate
    {
        $this->postcode = $postcode;
        return $this;
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

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (($this->rate > 0 && $this->rate < 1) || $this->rate > 100) {
            throw new InvalidArgumentException('Rate is supposed to be a number between 1 and 100 (or just 0)');
        }

        return true;
    }
}
