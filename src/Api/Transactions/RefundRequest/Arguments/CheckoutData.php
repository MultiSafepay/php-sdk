<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RefundRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Exception\InvalidArgumentException;
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
     * @param ShoppingCart $shoppingCart
     * @param string $taxTableSelector
     */
    public function generateFromShoppingCart(ShoppingCart $shoppingCart, string $taxTableSelector = '')
    {
        foreach ($shoppingCart->getItems() as $shoppingCartItem) {
            if ($taxTableSelector) {
                $shoppingCartItem->addTaxTableSelector($taxTableSelector);
            }

            $this->addItem($shoppingCartItem);
        }
    }

    /**
     * @param string $merchantItemId
     * @param int $quantity Set to 0 to refund all items
     * @throws InvalidArgumentException
     */
    public function refundByMerchantItemId(string $merchantItemId, int $quantity = 0)
    {
        if (count($this->items) < 1) {
            throw new InvalidArgumentException('No items provided in checkout data');
        }

        $foundItem = $this->getItemByMerchantItemId($merchantItemId);
        if ($quantity < 1 || $quantity > $foundItem->getQuantity()) {
            $quantity = $foundItem->getQuantity();
        }

        $refundItem = clone($foundItem);
        $refundItem->addQuantity($quantity);
        $refundItem->addUnitPrice($foundItem->getUnitPrice()->negative());

        $this->addItem($refundItem);
    }

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
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        $itemsData = [];

        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $itemsData[] = $item->getData();
            }
        }

        return array_merge(
            [
                'tax_table' => $this->taxTable ? $this->taxTable->getData() : null,
                'items' => $itemsData,
            ],
            $this->data
        );
    }

    /**
     * @param string $merchantItemId
     * @return CartItem
     * @throws InvalidArgumentException
     */
    private function getItemByMerchantItemId(string $merchantItemId): CartItem
    {
        foreach ($this->items as $item) {
            if ($item->getMerchantItemId() === $merchantItemId) {
                return $item;
            }
        }

        throw new InvalidArgumentException('No item found with merchant_item_id "' . $merchantItemId . '"');
    }
}
