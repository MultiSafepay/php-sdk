<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions;

/**
 * Trait TaxTableFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait CheckoutOptionsFixture
{
    /**
     * @return CheckoutOptions
     */
    public function createCheckoutOptionsFixture(): CheckoutOptions
    {
        $checkoutOptions = (new CheckoutOptions())
            ->addTaxTable($this->createTaxTableFixture());

        return $checkoutOptions;
    }
}
