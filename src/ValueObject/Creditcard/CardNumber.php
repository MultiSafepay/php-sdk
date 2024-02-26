<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Creditcard;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class CardNumber
 * @package MultiSafepay\ValueObject\Creditcard
 */
class CardNumber
{
    /**
     * @var string
     */
    private $cardNumber = '';

    /**
     * CardNumber constructor.
     * @param string $cardNumber
     * @throws InvalidArgumentException
     */
    public function __construct(string $cardNumber)
    {
        $this->validate($cardNumber);
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(string $cardNumber): bool
    {
        $cardNumber = str_replace(' ', '', $cardNumber);
        if (strlen($cardNumber) !== 16) {
            throw new InvalidArgumentException('Cardnumber must have 16 digits');
        }

        return true;
    }
}
