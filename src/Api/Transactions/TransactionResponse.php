<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Base\ResponseBody;
use MultiSafepay\Api\Transactions\TransactionResponse\CheckoutOptions;
use MultiSafepay\Api\Transactions\TransactionResponse\Costs;
use MultiSafepay\Api\Transactions\TransactionResponse\OrderAdjustment;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentMethod;
use MultiSafepay\Api\Transactions\TransactionResponse\RelatedTransaction;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item;
use MultiSafepay\ValueObject\CartItem;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Weight;

/**
 * Model TransactionResponse for containing transaction data received from the API
 * @package MultiSafepay\Api\Transactions
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class TransactionResponse extends ResponseBody
{
    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return (string)$this->get('transaction_id');
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return (string)$this->get('order_id');
    }

    /**
     * @return string
     */
    public function getPaymentLink(): string
    {
        return (string)$this->get('payment_url');
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return (string)$this->get('created');
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return (string)$this->get('modified');
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return (string)$this->get('currency');
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float)$this->get('amount');
    }

    /**
     * @return string
     */
    public function getMoney(): Money
    {
        $currency = $this->getCurrency();
        return Money::$currency($this->get('amount'));
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->get('description');
    }

    /**
     * @return string
     */
    public function getVar1(): string
    {
        return (string)$this->get('var1');
    }

    /**
     * @return string
     */
    public function getVar2(): string
    {
        return (string)$this->get('var2');
    }

    /**
     * @return string
     */
    public function getVar3(): string
    {
        return (string)$this->get('var3');
    }

    /**
     * @return string
     */
    public function getItemsHtml(): string
    {
        return (string)$this->get('items');
    }

    /**
     * @return float
     */
    public function getAmountRefunded(): float
    {
        return (float)$this->get('amount_refunded');
    }

    /**
     * @return string
     */
    public function getMoneyRefunded(): Money
    {
        $currency = $this->getCurrency();
        return Money::$currency($this->get('amount_refunded'));
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return (string)$this->get('status');
    }

    /**
     * @return string
     */
    public function getFinancialStatus(): string
    {
        return (string)$this->get('financial_status');
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return (string)$this->get('reason');
    }

    /**
     * @return string
     */
    public function getReasonCode(): string
    {
        return (string)$this->get('reason_code');
    }

    /**
     * @return string
     * @todo: What does a return of "NO" mean? Norway or a false?
     */
    public function getFastCheckout(): string
    {
        return (string)$this->get('fastcheckout');
    }

    /**
     * @return string
     */
    public function getCustomerAsArray(): array
    {
        return (array)$this->get('customer');
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return ((new Address))
            ->addStreetName((string)$this->get('address1'))
            ->addStreetNameAdditional((string)$this->get('address2'))
            ->addHouseNumber((string)$this->get('house_number'))
            ->addHouseNumberSuffix('') // @todo: What happened to house number prefix?
            ->addZipCode((string)$this->get('zip_code'))
            ->addCity((string)$this->get('city'))
            ->addState((string)$this->get('state'))
            ->addCountry(
                new Country($this->get('country'))
            );
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return (new Customer)
            ->addFirstName((string)$this->get('first_name'))
            ->addLastName((string)$this->get('last_name'))
            ->addAddress($this->getAddress())
            ->addEmailAddress(new EmailAddress((string)$this->get('email')))
            ->addPhoneNumber(new PhoneNumber((string)$this->get('phone1')))
            ->addPhoneNumber(new PhoneNumber((string)$this->get('phone2')));
    }

    /**
     * @return PaymentDetails
     */
    public function getPaymentDetails(): PaymentDetails
    {
        return new PaymentDetails((array)$this->get('payment_details'));
    }

    /**
     * @return Costs
     */
    public function getCosts(): Costs
    {
        return new Costs((array)$this->get('costs'));
    }

    /**
     * @return string
     */
    public function getPaymentUrl(): string
    {
        return (string)$this->get('payment_url');
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return (string)$this->get('cancel_url');
    }

    /**
     * @return RelatedTransaction[]
     */
    public function getRelatedTransactions(): array
    {
        $relatedTransactions = [];
        foreach ((array)$this->get('related_transactions') as $relatedTransaction) {
            $relatedTransactions[] = new RelatedTransaction($relatedTransaction);
        }

        return $relatedTransactions;
    }

    /**
     * @return PaymentMethod[]
     */
    public function getPaymentMethods(): array
    {
        $paymentMethods = [];
        foreach ((array)$this->get('payment_methods') as $paymentMethod) {
            $paymentMethods[] = new PaymentMethod($paymentMethod);
        }

        return $paymentMethods;
    }

    /**
     * @return ShoppingCart
     * @todo: Move these constructors to ShoppingCart & Item & Weight class itself
     */
    public function getShoppingCart(): ShoppingCart
    {
        $items = [];
        $shoppingCartData = $this->get('shopping_cart');
        if (!is_array($shoppingCartData) || empty($shoppingCartData['items'])) {
            return new ShoppingCart([]);
        }

        foreach ((array)$shoppingCartData['items'] as $dataItem) {
            // @todo: Implement cashback, image, product_url, options[]
            $items[] = $this->getItemFromData($dataItem);
        }

        return new ShoppingCart($items);
    }

    /**
     * @param array $data
     * @return CartItem
     */
    private function getItemFromData(array $data): CartItem
    {
        $currency = $data['currency'];
        $weight = new Weight($data['weight']['unit'], $data['weight']['value']);
        return (new CartItem)
            ->addName((string)$data['name'])
            ->addUnitPrice(Money::$currency($data['unit_price']))
            ->addQuantity((int)$data['quantity'])
            ->addMerchantItemId((string)$data['merchant_item_id'])
            ->addTaxTableSelector((string)$data['tax_table_selector'])
            ->addWeight($weight)
            ->addDescription((string)$data['description']);
    }

    /**
     * @return CheckoutOptions
     */
    public function getCheckoutOptions(): CheckoutOptions
    {
        return new CheckoutOptions((array)$this->get('checkout_options'));
    }

    /**
     * @return OrderAdjustment
     */
    public function getOrderAdjustment(): OrderAdjustment
    {
        return new OrderAdjustment((array)$this->get('order_adjustment'));
    }

    /**
     * @return string
     */
    public function getOrderTotal(): string
    {
        return (string)$this->get('order_total');
    }
}
