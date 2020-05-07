<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item;

/**
 * Class ShoppingCart
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class ShoppingCart
{
    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * ShoppingCart constructor.
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->addItems($items);
    }

    /**
     * @param array $items
     */
    public function addItems(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
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

        return [
            'items' => $itemsData,
        ];
    }
}
