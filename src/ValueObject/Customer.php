<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

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
     * @var PhoneNumber[]
     */
    private $phoneNumbers = [];

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
     * @param EmailAddress $emailAddress
     * @return Customer
     */
    public function addEmailAddress(EmailAddress $emailAddress): Customer
    {
        $this->emailAddress = $emailAddress;
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
     * @param PhoneNumber[] $phoneNumbers
     * @return Customer
     */
    public function addPhoneNumbers(array $phoneNumbers): Customer
    {
        foreach ($phoneNumbers as $phoneNumber) {
            $this->addPhoneNumber($phoneNumber);
        }

        return $this;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return Customer
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber): Customer
    {
        $this->phoneNumbers[] = $phoneNumber->get();
        return $this;
    }

    /**
     * @return IpAddress
     */
    public function getIpAddress(): ?IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailAddress(): ?EmailAddress
    {
        return $this->emailAddress;
    }

    /**
     * @return Address
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
     * @return PhoneNumber[]
     */
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }
}
