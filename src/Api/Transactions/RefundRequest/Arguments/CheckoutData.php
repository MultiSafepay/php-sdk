<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RefundRequest\Arguments;

use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData\Item;

/**
 * Class CustomerDetails
 * @package MultiSafepay\Api\Transactions\RefundRequest\Arguments
 */
class CheckoutData
{
    /**
     * @var Item[]
     */
    private $items;

    /**
     * CheckoutData constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     */
    public function addItems(array $items = [])
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
            'items' => $itemsData
        ];
    }
}
