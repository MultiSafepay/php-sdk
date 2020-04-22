<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use MultiSafepay\Api\Base;
use MultiSafepay\ValueObject\Customer;

/**
 * Class CustomerDetails
 * @package MultiSafepay\Api\Transactions\RequestOrder
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
     * @return Base\DataObject
     */
    public function getData(): array
    {
        $address = $this->getAddress();
        return [
            'address1' => $address->getStreetName(),
            'address2' => $address->getStreetNameAdditional(),
            'house_number' => $this->getHouseNumber(),
            'zip_code' => $address->getZipCode(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'country' => $address->getCountry()->getCode(),
            'country_name' => $address->getCountry()->getName(),
            'phone1' => $this->getPhoneNumbers()[0] ?? '',
            'phone2' => $this->getPhoneNumbers()[1] ?? '',
            'email' => $this->getEmailAddress()->get(),
            'ip_address' => $this->getIpAddress()->get(),
            'locale' => $this->getLocale(),
            'referrer' => $this->getReferrer(),
            'user_agent' => $this->getUserAgent(),
        ];
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

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function addLocale(string $locale): void
    {
        $this->locale = $locale;
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
     */
    public function addReferrer(string $referrer): void
    {
        $this->referrer = $referrer;
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
     */
    public function addUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }
}
