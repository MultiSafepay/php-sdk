<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

/**
 * Class IpAddress
 * @package MultiSafepay\ValueObject\Customer
 */
class IpAddress
{
    /**
     * @var string
     */
    private $ipAddress = '';

    /**
     * Country constructor.
     * @param string $ipAddress
     */
    public function __construct(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->ipAddress;
    }
}
