<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

/**
 * Class Address
 * @package MultiSafepay\ValueObject\Customer
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
     * @var string[]
     */
    private $phoneNumbers = [
        0 => '',
        1 => '',
    ];

    /**
     * Address constructor.
     * @param string $streetName
     * @param string $streetNameAdditional
     * @param string $houseNumber
     * @param string $houseNumberSuffix
     * @param string $zipCode
     * @param string $city
     * @param string $state
     * @param Country $country
     * @param array $phoneNumbers
     */
    public function __construct(
        string $streetName,
        string $streetNameAdditional,
        string $houseNumber,
        string $houseNumberSuffix,
        string $zipCode,
        string $city,
        string $state,
        Country $country,
        array $phoneNumbers
    ) {
        $this->streetName = $streetName;
        $this->streetNameAdditional = $streetNameAdditional;
        $this->houseNumber = $houseNumber;
        $this->houseNumberSuffix = $houseNumberSuffix;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->phoneNumbers = $phoneNumbers;
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

    /**
     * @return string[]
     */
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }
}
