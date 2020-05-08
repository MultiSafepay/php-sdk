<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;

use Money\Money;
use MultiSafepay\ValueObject\Weight;

/**
 * Class Item
 * @package MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData
 */
class Item
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Money|null
     */
    private $money;

    /**
     * @var string
     */
    private $merchantItemId;

    /**
     * @var Weight|null
     */
    private $weight;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $taxTableSelector;

    /**
     * Item constructor.
     * @param string $name
     * @param string $description
     * @param Money|null $money
     * @param int $quantity
     * @param string $merchantItemId
     * @param string $taxTableSelector
     * @param Weight|null $weight
     */
    public function __construct(
        string $name = '',
        string $description = '',
        ?Money $money = null,
        int $quantity = 0,
        string $merchantItemId = '',
        string $taxTableSelector = '',
        ?Weight $weight = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->money = $money;
        $this->quantity = $quantity;
        $this->merchantItemId = $merchantItemId;
        $this->weight = $weight;
        $this->taxTableSelector = $taxTableSelector;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->money->getAmount(),
            'currency' => $this->money->getCurrency(),
            'quantity' => $this->quantity,
            'merchant_item_id' => $this->merchantItemId,
            'tax_table_select' => $this->taxTableSelector,
            'weight' => [
                'unit' => $this->weight->getUnit(),
                'value' => $this->weight->getQuantity(),
            ]
        ];
    }
}
