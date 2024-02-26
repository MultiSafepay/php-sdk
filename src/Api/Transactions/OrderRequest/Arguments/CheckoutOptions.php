<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\CartItem;

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
     * @param ShoppingCart $shoppingCart
     * @return CheckoutOptions
     * @throws InvalidArgumentException
     */
    public function generateFromShoppingCart(ShoppingCart $shoppingCart): CheckoutOptions
    {
        $taxTable = new TaxTable();
        $taxRules = [];

        foreach ($shoppingCart->getItems() as $cartItem) {
            if ($cartItem->hasTaxRate()) {
                $taxRules[(string)$cartItem->getTaxRate()] = $this->getTaxRuleFromCartItem($cartItem);
            }
        }

        if (!empty($taxRules)) {
            $taxTable->addTaxRules($taxRules);
            $this->addTaxTable($taxTable);
        }

        return $this;
    }

    /**
     * Retrieve the tax rules from the tax table
     *
     * @return TaxTable
     */
    public function getTaxTable(): TaxTable
    {
        if (!$this->taxTable) {
            $this->taxTable = new TaxTable();
        }
        return $this->taxTable;
    }

    /**
     * Add a new tax table
     *
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
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        return array_merge(
            [
                'tax_tables' => $this->taxTable ? $this->taxTable->getData() : null,
            ],
            $this->data
        );
    }

    /**
     * @param CartItem $cartItem
     * @return TaxRule
     * @throws InvalidArgumentException
     */
    private function getTaxRuleFromCartItem(CartItem $cartItem): TaxRule
    {
        $taxRate = new TaxRate();
        $taxRate->addRate($cartItem->getTaxRate());

        $taxRule = new TaxRule();
        $taxRule->addName($cartItem->getTaxTableSelector());
        $taxRule->addTaxRate($taxRate);

        return $taxRule;
    }
}
