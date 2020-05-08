<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
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
    private $phoneNumber = '';

    /**
     * Country constructor.
     * @param string $phoneNumber
     */
    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $this->filter($phoneNumber);
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return string
     */
    private function filter(string $phoneNumber): string
    {
        return preg_replace('/([^0-9]+)/', '', $phoneNumber);
    }
}
