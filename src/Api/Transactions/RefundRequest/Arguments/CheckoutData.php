<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RefundRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\ValueObject\CartItem;

/**
 * Class CustomerDetails
 * @package MultiSafepay\Api\Transactions\RefundRequest\Arguments
 */
class CheckoutData extends DataObject
{
    /**
     * @var CartItem[]
     */
    private $items;

    /**
     * @var TaxTable
     */
    private $taxTable;

    /**
     * @param TaxTable $taxTable
     * @return CheckoutData
     */
    public function addTaxTable(TaxTable $taxTable): CheckoutData
    {
        $this->taxTable = $taxTable;
        return $this;
    }

    /**
     * @param CartItem[] $items
     * @return CheckoutData
     */
    public function addItems(array $items = []): CheckoutData
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * @param CartItem $item
     * @return CheckoutData
     */
    public function addItem(CartItem $item): CheckoutData
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $itemsData = [];
        foreach ($this->items as $item) {
            $itemsData[] = $item->getData();
        }

        return array_merge(
            [
                'tax_table' => $this->taxTable ? $this->taxTable->getData() : null,
                'items' => $itemsData
            ],
            $this->data
        );
    }
}
