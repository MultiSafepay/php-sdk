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
     * Customer constructor.
     * @param string $firstName
     * @param string $lastName
     * @param Address $address
     * @param IpAddress $ipAddress
     * @param EmailAddress $emailAddress
     */
    public function __construct(
        string $firstName,
        string $lastName,
        Address $address,
        IpAddress $ipAddress,
        EmailAddress $emailAddress
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->ipAddress = $ipAddress;
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return IpAddress
     */
    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
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
}
