<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\IpAddress;
use MultiSafepay\ValueObject\Customer\EmailAddress;

/**
 * Class Customer
 * @package MultiSafepay\Api\Base
 */
class Customer
{
    /**
     * @var IpAddress
     */
    private $ipAddress;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var string
     */
    private $firstName = '';

    /**
     * @var string
     */
    private $lastName = '';

    /**
     * @return IpAddress
     */
    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @param IpAddress $ipAddress
     */
    public function changeIpAddress(IpAddress $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    /**
     * @param EmailAddress $emailAddress
     */
    public function changeEmailAddress(EmailAddress $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function changeAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function changeFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function changeLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
