<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Api\Base;

/**
 * Class Customer
 * @package MultiSafepay\Api\Base
 */
class Customer extends Base\DataObject
{
    /**
     * @param string $ipAddress
     * @return Base\DataObject
     * @todo Add input validation why a value object IpAddress
     */
    public function addIpAddress(string $ipAddress)
    {
        return $this->addData(['ip_address' => $ipAddress]);
    }

    /**
     * @param string $firstName
     * @return Base\DataObject
     */
    public function addFirstName(string $firstName)
    {
        return $this->addData(['first_name' => $firstName]);
    }

    /**
     * @param string $lastName
     * @return Base\DataObject
     */
    public function addLastName(string $lastName)
    {
        return $this->addData(['last_name' => $lastName]);
    }

    /**
     * @param string $address
     * @return Base\DataObject
     */
    public function addAddress(string $address)
    {
        return $this->addData(['address1' => $address]);
    }

    /**
     * @param string $houseNumber
     * @return Base\DataObject
     */
    public function addHouseNumber(string $houseNumber)
    {
        return $this->addData(['house_number' => $houseNumber]);
    }

    /**
     * @param string $zipCode
     * @return Base\DataObject
     * @todo Add input validation why a value object ZipCode
     */
    public function addZipCode(string $zipCode)
    {
        return $this->addData(['zip_code' => $zipCode]);
    }

    /**
     * @param string $city
     * @return Base\DataObject
     */
    public function addCity(string $city)
    {
        return $this->addData(['city' => $city]);
    }

    /**
     * @param string $country
     * @return Base\DataObject
     * @todo Add input validation why a value object Country
     */
    public function addCountry(string $country)
    {
        return $this->addData(['country' => $country]);
    }

    /**
     * @param string $phone
     * @return Base\DataObject
     */
    public function addPhone(string $phone)
    {
        return $this->addData(['phone' => $phone]);
    }

    /**
     * @param string $email
     * @return Base\DataObject
     * @todo Add input validation why a value object Email
     */
    public function addEmail(string $email)
    {
        return $this->addData(['email' => $email]);
    }
}
