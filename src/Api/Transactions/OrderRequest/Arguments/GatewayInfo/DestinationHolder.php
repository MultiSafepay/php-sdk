<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

/**
 * Class DestinationHolder
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class DestinationHolder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $iban;

    /**
     * @var string
     */
    private $swift;

    /**
     * @param string $name
     * @return DestinationHolder
     */
    public function addName(string $name): DestinationHolder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $city
     * @return DestinationHolder
     */
    public function addCity(string $city): DestinationHolder
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param string $country
     * @return DestinationHolder
     */
    public function addCountry(string $country): DestinationHolder
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param string $iban
     * @return DestinationHolder
     */
    public function addIban(string $iban): DestinationHolder
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @param string $swift
     * @return DestinationHolder
     */
    public function addSwift(string $swift): DestinationHolder
    {
        $this->swift = $swift;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'destination_holder_name' => $this->name,
            'destination_holder_city' => $this->city,
            'destination_holder_country' => $this->country,
            'destination_holder_iban' => $this->iban,
            'destination_holder_swift' => $this->swift,
        ];
    }
}
