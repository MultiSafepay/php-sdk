<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class CheckoutOptions
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class CheckoutOptions extends DataObject
{
    /**
     * @var TaxTable
     */
    private $taxTable;

    /**
     * @param TaxTable $taxTable
     * @return CheckoutOptions
     */
    public function addTaxTable(TaxTable $taxTable): CheckoutOptions
    {
        $this->taxTable = $taxTable;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return array_merge(
            [
                'tax_tables' => $this->taxTable ? $this->taxTable->getData() : null
            ],
            $this->data
        );
    }
}
