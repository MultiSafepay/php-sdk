<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;

/**
 * Class Customer
 * @package MultiSafepay\ValueObject
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
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
     * @var string
     */
    private $companyName = '';

    /**
     * @var PhoneNumber
     */
    private $phoneNumber;

    /**
     * @param IpAddress $ipAddress
     * @return Customer
     */
    public function addIpAddress(IpAddress $ipAddress): Customer
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @param string $ipAddress
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function addIpAddressAsString(string $ipAddress): Customer
    {
        $this->ipAddress = new IpAddress($ipAddress);
        return $this;
    }

    /**
     * @param EmailAddress $emailAddress
     * @return Customer
     */
    public function addEmailAddress(EmailAddress $emailAddress): Customer
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @param string $emailAddress
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function addEmailAddressAsString(string $emailAddress): Customer
    {
        $this->emailAddress = new EmailAddress($emailAddress);
        return $this;
    }

    /**
     * @param Address $address
     * @return Customer
     */
    public function addAddress(Address $address): Customer
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param string $firstName
     * @return Customer
     */
    public function addFirstName(string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return Customer
     */
    public function addLastName(string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param string $companyName
     * @return Customer
     */
    public function addCompanyName(string $companyName): Customer
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return Customer
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber): Customer
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @param string $phoneNumber
     * @return Customer
     */
    public function addPhoneNumberAsString(string $phoneNumber): Customer
    {
        $this->phoneNumber = new PhoneNumber($phoneNumber);
        return $this;
    }

    /**
     * @return IpAddress|null
     */
    public function getIpAddress(): ?IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return EmailAddress|null
     */
    public function getEmailAddress(): ?EmailAddress
    {
        return $this->emailAddress;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhoneNumber(): ?PhoneNumber
    {
        return $this->phoneNumber;
    }
}
