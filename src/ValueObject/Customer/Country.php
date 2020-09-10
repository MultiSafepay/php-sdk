<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Country
 * @package MultiSafepay\ValueObject\Customer
 */
class Country
{
    /**
     * @var string
     */
    private $code = '';

    /**
     * Country constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        if (strlen($code) !== 2) {
            throw new InvalidArgumentException('Country code should be 2 characters (ISO3166 alpha 2)');
        }

        $this->code = strtoupper($code);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
