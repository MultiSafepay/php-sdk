<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Arguments\GatewayInfo;

/**
 * Class DestinationHolder
 * @package MultiSafepay\Api\Transactions\RequestOrder\Arguments\GatewayInfo
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
     * GatewayInfoIdeal constructor.
     * @param string $name
     * @param string $city
     * @param string $country
     * @param string $iban
     * @param string $swift
     */
    public function __construct(string $name, string $city, string $country, string $iban, string $swift)
    {
        $this->name = $name;
        $this->city = $city;
        $this->country = $country;
        $this->iban = $iban;
        $this->swift = $swift;
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
