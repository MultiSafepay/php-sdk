<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\IpAddress;

/**
 * Class CustomerDetails
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class CustomerDetails extends Customer
{
    /**
     * @var string
     */
    private $locale = 'en';

    /**
     * @var string
     */
    private $referrer = '';

    /**
     * @var string
     */
    private $userAgent = '';

    /**
     * @var IpAddress
     */
    private $forwardedIp;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return array
     * phpcs:disable ObjectCalisthenics.Files.FunctionLength
     */
    public function getData(): array
    {
        $address = $this->getAddress();
        $phoneNumbers = $this->getPhoneNumbers();
        $data = [
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastName(),
            'address1' => $address->getStreetName(),
            'address2' => $address->getStreetNameAdditional(),
            'house_number' => $this->getHouseNumber(),
            'zip_code' => $address->getZipCode(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'country' => $address->getCountry() ? $address->getCountry()->getCode() : null,
            'country_name' => $address->getCountry() ? $address->getCountry()->getName() : null,
            'phone1' => $phoneNumbers[0] ?? null,
            'phone2' => $phoneNumbers[1] ?? null,
            'email' => $this->getEmailAddress() ? $this->getEmailAddress()->get() : null,
            'ip_address' => $this->getIpAddress() ? $this->getIpAddress()->get() : null,
            'locale' => $this->getLocale(),
            'referrer' => $this->getReferrer(),
            'forwarded_ip' => $this->getUserAgent(),
            'user_agent' => $this->getUserAgent(),
        ];

        $data = array_merge($data, $this->data);

        return $data;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return CustomerDetails
     */
    public function addLocale(string $locale): CustomerDetails
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer(): string
    {
        return $this->referrer;
    }

    /**
     * @param string $referrer
     * @return CustomerDetails
     */
    public function addReferrer(string $referrer): CustomerDetails
    {
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * @return IpAddress
     */
    public function getForwardedIp(): IpAddress
    {
        return $this->forwardedIp;
    }

    /**
     * @param IpAddress $forwardedIp
     * @return CustomerDetails
     */
    public function addForwardedIp(IpAddress $forwardedIp): CustomerDetails
    {
        $this->forwardedIp = $forwardedIp;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return CustomerDetails
     */
    public function addUserAgent(string $userAgent): CustomerDetails
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @param array $data
     * @return CustomerDetails
     */
    public function addData(array $data = []): CustomerDetails
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * @return string
     */
    private function getHouseNumber(): string
    {
        $address = $this->getAddress();
        $houseNumber = $address->getHouseNumber();
        $houseNumberSuffix = $address->getHouseNumberSuffix();

        if ($houseNumberSuffix) {
            $houseNumber .= ' ' . $houseNumberSuffix;
        }

        return $houseNumber;
    }
}
