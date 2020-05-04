<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use MultiSafepay\ValueObject\Tax\TaxRate;
use MultiSafepay\ValueObject\Tax\TaxRule;
use MultiSafepay\ValueObject\Tax\TaxTable;

/**
 * Trait TaxTableFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait TaxTableFixture
{
    /**
     * @return TaxTable
     */
    public function createTaxTableFixture(): TaxTable
    {
        $defaultRate = new TaxRate(0);
        $alternateRates = [];
        $alternateRates[] = new TaxRule('BTW21', [new TaxRate(21)]);
        $alternateRates[] = new TaxRule('BTW6', [new TaxRate(6)]);
        $alternateRates[] = new TaxRule('BTW0', [new TaxRate(0)]);
        $alternateRates[] = new TaxRule('none', [new TaxRate(0)]);

        return new TaxTable($defaultRate, $alternateRates, false);
    }
}
