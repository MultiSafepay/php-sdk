<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

/**
 * Class BankAccount
 * @package MultiSafepay\ValueObject
 */
class BankAccount
{
    /**
     * @var string
     */
    private $bankAccount = '';

    /**
     * Country constructor.
     * @param string $bankAccount
     */
    public function __construct(string $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->bankAccount;
    }
}
