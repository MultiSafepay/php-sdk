<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;

/**
 * Trait TaxTableFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait TaxTableFixture
{
    /**
     * @return TaxTable
     */
    public function createTaxTableFixture(): TaxTable
    {
        $defaultRate = new TaxRate();
        $defaultRate->addRate(0);

        $alternateRates = [];
        $alternateRates[] = (new TaxRule)->addName('BTW21')->addTaxRates([(new TaxRate())->addRate(21)]);
        $alternateRates[] = (new TaxRule)->addName('BTW6')->addTaxRates([(new TaxRate())->addRate(6)]);
        $alternateRates[] = (new TaxRule)->addName('BTW0')->addTaxRates([(new TaxRate())->addRate(0)]);
        $alternateRates[] = (new TaxRule)->addName('none')->addTaxRates([(new TaxRate())->addRate(0)]);

        return new TaxTable($defaultRate, $alternateRates, false);
    }
}
