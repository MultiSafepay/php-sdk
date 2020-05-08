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
     * Item constructor.
     * @param string $name
     * @param Money $unitPrice
     * @param int $quantity
     * @param string $merchantItemId
     * @param string $taxTableSelector
     * @param Weight $weight
     * @param string $description
     */
    public function __construct(
        string $name,
        Money $unitPrice,
        int $quantity,
        string $merchantItemId,
        string $taxTableSelector,
        Weight $weight,
        string $description = ''
    ) {
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->merchantItemId = $merchantItemId;
        $this->taxTableSelector = $taxTableSelector;
        $this->weight = $weight;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice->getAmount(), // @todo: Price in Euro, not Euro-cents?
            'quantity' => $this->quantity,
            'merchant_item_id' => $this->merchantItemId,
            'tax_table_select' => $this->taxTableSelector,
            'weight' => [
                'unit' => strtoupper($this->weight->getUnit()),
                'value' => $this->weight->getQuantity(),
            ]
        ];
    }
}
