<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Util;

use MultiSafepay\ValueObject\Money;

/**
 * Class MoneyFormatter
 * @package MultiSafepay\Util
 */
class MoneyFormatter
{
    /**
     * @param Money|string|int|float $amount
     * @return string
     */
    public function toDecimalString($amount): string
    {
        if ($amount instanceof Money) {
            $amount = $amount->getAmount();
        }

        if (empty($amount)) {
            return '0.00';
        }

        $float = (float)$amount / 100;
        return number_format($float, 10, '.', '');
    }
}
