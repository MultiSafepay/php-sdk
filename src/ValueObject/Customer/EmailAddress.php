<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

/**
 * Class EmailAddress
 * @package MultiSafepay\ValueObject\Customer
 */
class EmailAddress
{
    /**
     * @var string
     */
    private $emailAddress = '';

    /**
     * Country constructor.
     * @param string $emailAddress
     */
    public function __construct(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->emailAddress;
    }
}
