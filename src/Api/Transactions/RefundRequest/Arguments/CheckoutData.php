<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RefundRequest\Arguments;

use MultiSafepay\ValueObject\CartItem;

/**
 * Class CustomerDetails
 * @package MultiSafepay\Api\Transactions\RefundRequest\Arguments
 */
class CheckoutData
{
    /**
     * @var CartItem[]
     */
    private $items;

    /**
     * CheckoutData constructor.
     * @param CartItem[] $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param CartItem[] $items
     */
    public function addItems(array $items = [])
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
     * @return array
     */
    public function getData(): array
    {
        $itemsData = [];
        foreach ($this->items as $item) {
            $itemsData[] = $item->getData();
        }

        return [
            'items' => $itemsData
        ];
    }
}
