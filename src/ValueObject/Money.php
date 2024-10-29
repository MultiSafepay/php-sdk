<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Util\MoneyFormatter;

/**
 * Class Money
 * @package MultiSafepay\ValueObject
 * @deprecated since version 5.15.0, will be removed in version 7.0.0
 * Replaced by ValueObject\Amount, ValueObject\UnitPrice and ValueObject\Currency
 */
class Money
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * Money constructor.
     *
     * @param float $amount
     * Amount in full units like Euros for CartItem $unitPrice
     * Amount in cents for OrderRequest $money
     * Amount in cents for UpdateRequest $partialShipmentAmount
     *
     * @param string $currency Currency code, like EUR
     */
    public function __construct(float $amount, string $currency = 'EUR')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getAmountInCents(): float
    {
        return $this->amount * 100;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return Money
     */
    public function negative(): Money
    {
        $amount = 0 - $this->amount;
        return new Money($amount, $this->currency);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (new MoneyFormatter())->toDecimalString($this);
    }
}
