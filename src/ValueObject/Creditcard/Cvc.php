<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Creditcard;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Cvc
 * @package MultiSafepay\ValueObject\Creditcard
 */
class Cvc
{
    /**
     * @var string
     */
    private $cvc = '';

    /**
     * CardNumber constructor.
     * @param string $cvc
     * @throws InvalidArgumentException
     */
    public function __construct(string $cvc)
    {
        $this->validate($cvc);
        $this->cvc = $cvc;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->cvc;
    }

    /**
     * @param string $cvc
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(string $cvc): bool
    {
        $cvc = str_replace(' ', '', $cvc);
        if (strlen($cvc) !== 3) {
            throw new InvalidArgumentException('CVC must have 3 digits');
        }

        if (!is_numeric($cvc)) {
            throw new InvalidArgumentException('CVC must be a number');
        }

        return true;
    }
}
