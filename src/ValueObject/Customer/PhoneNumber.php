<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

/**
 * Class PhoneNumber
 * @package MultiSafepay\ValueObject\Customer
 */
class PhoneNumber
{
    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * Country constructor.
     * @param string $phoneNumber
     */
    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->phoneNumber;
    }
}
