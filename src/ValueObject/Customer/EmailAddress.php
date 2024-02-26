<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

use MultiSafepay\Exception\InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public function __construct(string $emailAddress)
    {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Value "' . $emailAddress . '" is not a valid email address');
        }

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
