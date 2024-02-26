<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Address
 * @package MultiSafepay\ValueObject\Customer
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 */
class Address
{
    /**
     * @var string
     */
    private $streetName = '';

    /**
     * @var string
     */
    private $streetNameAdditional = '';

    /**
     * @var string
     */
    private $houseNumber = '';

    /**
     * @var string
     */
    private $houseNumberSuffix = '';

    /**
     * @var string
     */
    private $zipCode = '';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var string
     */
    private $state = '';

    /**
     * @var Country
     */
    private $country;

    /**
     * @param string $streetName
     * @return Address
     */
    public function addStreetName(string $streetName): Address
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @param string $streetNameAdditional
     * @return Address
     */
    public function addStreetNameAdditional(string $streetNameAdditional): Address
    {
        $this->streetNameAdditional = $streetNameAdditional;
        return $this;
    }

    /**
     * @param string $houseNumber
     * @return Address
     */
    public function addHouseNumber(string $houseNumber): Address
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     * @param string $houseNumberSuffix
     * @return Address
     */
    public function addHouseNumberSuffix(string $houseNumberSuffix): Address
    {
        $this->houseNumberSuffix = $houseNumberSuffix;
        return $this;
    }

    /**
     * @param string $zipCode
     * @return Address
     */
    public function addZipCode(string $zipCode): Address
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function addCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param string $state
     * @return Address
     */
    public function addState(string $state): Address
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param Country $country
     * @return Address
     */
    public function addCountry(Country $country): Address
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param string $countryCode
     * @return Address
     * @throws InvalidArgumentException
     */
    public function addCountryCode(string $countryCode): Address
    {
        $this->country = new Country($countryCode);
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @return string
     */
    public function getStreetNameAdditional(): string
    {
        return $this->streetNameAdditional;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @return string
     */
    public function getHouseNumberSuffix(): string
    {
        return $this->houseNumberSuffix;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }
}
