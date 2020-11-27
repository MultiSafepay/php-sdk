<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
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
     */
    public function generateFromShoppingCart(ShoppingCart $shoppingCart): CheckoutOptions
    {
        $taxTable = new TaxTable;
        $taxRules = [];

        foreach ($shoppingCart->getItems() as $cartItem) {
            if ($cartItem->hasTaxRate()) {
                $taxRules[(string)$cartItem->getTaxRate()] = $this->getTaxRuleFromCartItem($cartItem);
            }
        }

        if (!empty($taxRules)) {
            //$taxTable->addDefaultRate((new TaxRate)->addRate(0));
            $taxTable->addTaxRules($taxRules);
            $this->addTaxTable($taxTable);
        }

        return $this;
    }

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

    /**
     * @param CartItem $cartItem
     * @return TaxRule
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
