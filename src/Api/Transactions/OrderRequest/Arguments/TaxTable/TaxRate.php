<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
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
     * @param float $rate
     * @return TaxRate
     * @throws InvalidArgumentException
     */
    public function addRate(float $rate): TaxRate
    {
        if (($rate > 0 && $rate < 1) || $rate > 100) {
            throw new InvalidArgumentException('Rate is supposed to be a number between 1 and 100 (or just 0)');
        }

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
     * @param string $countryCode
     * @return TaxRate
     * @throws InvalidArgumentException
     */
    public function addCountryCode(string $countryCode): TaxRate
    {
        $this->country = new Country($countryCode);
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
     * @return bool
     * @deprecated Validation is taken care off by
     */
    public function validate(): bool
    {
        return true;
    }
}
