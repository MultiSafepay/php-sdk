<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

class Currency
{
    /**
     * @var string
     */
    private $currency;

    /**
     * Currency should be given in ISO 4217 format, for more information see: https://en.wikipedia.org/wiki/ISO_4217
     *
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->currency;
    }
}
