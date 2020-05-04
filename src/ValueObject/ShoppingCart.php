<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\ValueObject\ShoppingCart\Item;

/**
 * Class ShoppingCart
 * @package MultiSafepay\ValueObject
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
        $this->setItems($items);
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
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
