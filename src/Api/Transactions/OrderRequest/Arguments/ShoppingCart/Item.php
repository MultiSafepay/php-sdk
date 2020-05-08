<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;

use Money\Money;
use MultiSafepay\ValueObject\Weight;

/**
 * Class Item
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart
 */
class Item
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $merchantItemId;

    /**
     * @var string
     */
    private $taxTableSelector;

    /**
     * @var Weight
     */
    private $weight;

    /**
     * @var string
     */
    private $description;

    /**
     * @param string $name
     * @return Item
     */
    public function addName(string $name): Item
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Money $unitPrice
     * @return Item
     */
    public function addUnitPrice(Money $unitPrice): Item
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * @param int $quantity
     * @return Item
     */
    public function addQuantity(int $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param string $merchantItemId
     * @return Item
     */
    public function addMerchantItemId(string $merchantItemId): Item
    {
        $this->merchantItemId = $merchantItemId;
        return $this;
    }

    /**
     * @param string $taxTableSelector
     * @return Item
     */
    public function addTaxTableSelector(string $taxTableSelector): Item
    {
        $this->taxTableSelector = $taxTableSelector;
        return $this;
    }

    /**
     * @param Weight $weight
     * @return Item
     */
    public function addWeight(Weight $weight): Item
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @param string $description
     * @return Item
     */
    public function addDescription(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        // @todo: unit_price in Euro, not Euro-cents?
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice ? $this->unitPrice->getAmount() : null,
            'currency' => $this->unitPrice ? $this->unitPrice->getCurrency() : null,
            'quantity' => $this->quantity,
            'merchant_item_id' => $this->merchantItemId,
            'tax_table_select' => $this->taxTableSelector,
            'weight' => [
                'unit' => $this->weight ? strtoupper($this->weight->getUnit()) : null,
                'value' => $this->weight ? $this->weight->getQuantity() : null,
            ]
        ];
    }
}
