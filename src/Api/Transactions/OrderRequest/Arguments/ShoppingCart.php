<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\CartItem;

/**
 * Class ShoppingCart
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class ShoppingCart
{
    /**
     * @var CartItem[]
     */
    private $items = [];

    /**
     * ShoppingCart constructor.
     * @param CartItem[] $items
     */
    public function __construct(array $items)
    {
        $this->addItems($items);
    }

    /**
     * @param CartItem[] $items
     */
    public function addItems(array $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @param CartItem $item
     */
    public function addItem(CartItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->validate();

        $itemsData = [];
        foreach ($this->items as $item) {
            $itemsData[] = $item->getData();
        }

        return [
            'items' => $itemsData,
        ];
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (empty($this->items)) {
            throw new InvalidArgumentException('No items in cart');
        }

        return true;
    }
}
