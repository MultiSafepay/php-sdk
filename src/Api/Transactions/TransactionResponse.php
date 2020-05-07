<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Base\ResponseBody;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\ShoppingCart;
use MultiSafepay\ValueObject\ShoppingCart\Item;
use MultiSafepay\ValueObject\Tax\TaxRate;
use MultiSafepay\ValueObject\Tax\TaxRule;
use MultiSafepay\ValueObject\Tax\TaxTable;
use MultiSafepay\ValueObject\Weight;

/**
 * Model TransactionResponse for containing transaction data received from the API
 * @package MultiSafepay\Api\Transactions
 */
class TransactionResponse extends ResponseBody
{
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
    public function getOrderId(): string
    {
        return (string)$this->get('order_id');
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
     * @return array
     */
    public function getItems(): array
    {
        return (array)$this->get('items'); // @todo: What kind of items can we expect?
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
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        $address = new Address(
            (string)$this->get('address1'),
            (string)$this->get('address2'),
            (string)$this->get('house_number'),
            '', // @todo: What happened to house number prefix?
            (string)$this->get('zip_code'),
            (string)$this->get('city'),
            (string)$this->get('state'),
            new Country($this->get('country'))
        );

        $customer = new Customer(
            (string)$this->get('first_name'),
            (string)$this->get('last_name'),
            $address,
            null,
            new EmailAddress((string)$this->get('email')),
            [
                new PhoneNumber((string)$this->get('phone1')),
                new PhoneNumber((string)$this->get('phone2'))
            ]
        );
        return $customer;
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
     * @todo: Is this always the same thing?
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
        if (is_array($shoppingCartData) && isset($shoppingCartData['items'])) {
            foreach ((array)$shoppingCartData['items'] as $dataItem) {
                $currency = $dataItem['currency'];
                $weight = new Weight($dataItem['weight']['unit'], $dataItem['weight']['value']);
                // @todo: Implement cashback, image, product_url, options[]
                $items[] = new Item(
                    (string)$dataItem['name'],
                    Money::$currency($dataItem['unit_price']),
                    (int)$dataItem['quantity'],
                    (string)$dataItem['merchant_item_id'],
                    (string)$dataItem['tax_table_selector'],
                    $weight,
                    (string)$dataItem['description']
                );
            }
        }

        $shoppingCart = new ShoppingCart($items);
        return $shoppingCart;
    }

    /**
     * @return TaxTable
     * @todo: Move these constructors to TaxRate, TaxRule classes themselves
     */
    public function getTaxTable(): TaxTable
    {
        $checkoutOptionsData = $this->get('checkout_options');
        if (!$checkoutOptionsData) {
            throw new InvalidArgumentException('Unable to parse checkout options for this response');
        }

        $default = $checkoutOptionsData['default'];
        $defaultTaxRate = new TaxRate((float)$default['rate']);

        $taxRules = [];
        foreach ($checkoutOptionsData['alternate'] as $alternateData) {
            $taxRates = [];
            foreach ($alternateData['rules'] as $ruleData) {
                $taxRates[] = new TaxRate(
                    (float)$ruleData['rate'],
                    $ruleData['country'] ? new Country($ruleData['country']) : null,
                    $ruleData['state'],
                    $ruleData['postcode']
                );
            }
            $taxRules[] = new TaxRule($alternateData['name'], $taxRates);
        }

        $taxTable = new TaxTable($defaultTaxRate, $taxRules, (bool)$default['shipping_taxed']);
        return $taxTable;
    }

    public function getCheckoutOptions()
    {
        // @todo: Implement this or not?
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
