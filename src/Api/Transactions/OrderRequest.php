<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Api\Transactions\OrderRequest\Direct;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class OrderRequest
 * @package MultiSafepay\Api\Transactions
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class OrderRequest implements OrderRequestInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var Money
     */
    protected $money;

    /**
     * @var string
     */
    protected $gatewayCode;

    /**
     * @var PaymentOptions
     */
    protected $paymentOptions;

    /**
     * @var GatewayInfoInterface
     */
    protected $gatewayInfo;

    /**
     * @var Description
     */
    protected $description;

    /**
     * @var CustomerDetails
     */
    protected $customerDetails;

    /**
     * @var string
     */
    protected $recurringId;

    /**
     * @var SecondChance|null
     */
    protected $secondChance;

    /**
     * @var GoogleAnalytics|null
     */
    protected $googleAnalytics;

    /**
     * @var ShoppingCart
     */
    protected $shoppingCart;

    /**
     * @var CustomerDetails
     */
    protected $customer;

    /**
     * @var CustomerDetails
     */
    protected $delivery;

    /**
     * @var TaxTable
     */
    protected $taxTable;

    /**
     * @var int
     */
    protected $secondsActive;

    /**
     * @var int
     */
    protected $daysActive;

    /**
     * @var PluginDetails
     */
    protected $pluginDetails;

    /**
     * @param string $type
     * @return OrderRequest
     */
    public function addType(string $type): OrderRequest
    {
        $allowedTypes = ['direct', 'redirect'];
        if (!in_array($type, $allowedTypes)) {
            $msg = 'Type "' . $type . '" is not a known type. ';
            $msg .= 'Available types: ' . implode(', ', $allowedTypes);
            throw new InvalidArgumentException($msg);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @param string $orderId
     * @return OrderRequest
     */
    public function addOrderId(string $orderId): OrderRequest
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @param Money $money
     * @return OrderRequest
     */
    public function addMoney(Money $money): OrderRequest
    {
        $this->money = $money;
        return $this;
    }

    /**
     * @param Gateway $gateway
     * @return OrderRequest
     */
    public function addGateway(Gateway $gateway): OrderRequest
    {
        $this->gatewayCode = $gateway->getId();
        return $this;
    }

    /**
     * @param string $gatewayCode
     * @return OrderRequest
     */
    public function addGatewayCode(string $gatewayCode): OrderRequest
    {
        $this->gatewayCode = $gatewayCode;
        return $this;
    }

    /**
     * @param GatewayInfoInterface $gatewayInfo
     * @return OrderRequest
     */
    public function addGatewayInfo(GatewayInfoInterface $gatewayInfo): OrderRequest
    {
        $this->gatewayInfo = $gatewayInfo;
        return $this;
    }

    /**
     * @param PaymentOptions $paymentOptions
     * @return OrderRequest
     */
    public function addPaymentOptions(PaymentOptions $paymentOptions): OrderRequest
    {
        $this->paymentOptions = $paymentOptions;
        return $this;
    }

    /**
     * @param Description $description
     * @return OrderRequest
     */
    public function addDescription(Description $description): OrderRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param PluginDetails $pluginDetails
     * @return OrderRequest
     */
    public function addPluginDetails(PluginDetails $pluginDetails): OrderRequest
    {
        $this->pluginDetails = $pluginDetails;
        return $this;
    }


    /**
     * @param CustomerDetails $customerDetails
     * @return OrderRequest
     */
    public function addCustomerDetails(CustomerDetails $customerDetails): OrderRequest
    {
        $this->customerDetails = $customerDetails;
        return $this;
    }

    /**
     * @param string $recurringId
     * @return OrderRequest
     */
    public function addRecurringId(string $recurringId): OrderRequest
    {
        $this->recurringId = $recurringId;
        return $this;
    }

    /**
     * @param SecondChance $secondChance
     * @return OrderRequest
     */
    public function addSecondChance(SecondChance $secondChance): OrderRequest
    {
        $this->secondChance = $secondChance;
        return $this;
    }

    /**
     * @param GoogleAnalytics $googleAnalytics
     * @return OrderRequest
     */
    public function addGoogleAnalytics(GoogleAnalytics $googleAnalytics): OrderRequest
    {
        $this->googleAnalytics = $googleAnalytics;
        return $this;
    }

    /**
     * @param ShoppingCart $shoppingCart
     * @return OrderRequest
     */
    public function addShoppingCart(ShoppingCart $shoppingCart): OrderRequest
    {
        $this->shoppingCart = $shoppingCart;
        return $this;
    }

    /**
     * @param CustomerDetails $customer
     * @return OrderRequest
     */
    public function addCustomer(CustomerDetails $customer): OrderRequest
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @param CustomerDetails $delivery
     * @return OrderRequest
     */
    public function addDelivery(CustomerDetails $delivery): OrderRequest
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @param TaxTable $taxTable
     * @return OrderRequest
     */
    public function addTaxTable(TaxTable $taxTable): OrderRequest
    {
        $this->taxTable = $taxTable;
        return $this;
    }

    /**
     * @param int $seconds
     * @return OrderRequest
     */
    public function addSecondsActive(int $seconds): OrderRequest
    {
        $this->secondsActive = $seconds;
        return $this;
    }

    /**
     * @param int $days
     * @return OrderRequest
     */
    public function addDaysActive(int $days): OrderRequest
    {
        $this->daysActive = $days;
        return $this;
    }

    /**
     * @return array
     * phpcs:disable ObjectCalisthenics.Files.FunctionLength
     */
    public function getData(): array
    {
        $this->validate();

        return [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'currency' => $this->money ? (string)$this->money->getCurrency() : null,
            'amount' => $this->money ? (string)((float)$this->money->getAmount() * 100) : null,
            'gateway' => $this->gatewayCode,
            'gateway_info' => $this->gatewayInfo ? $this->gatewayInfo->getData() : null,
            'payment_options' => $this->paymentOptions ? $this->paymentOptions->getData() : null,
            'description' => ($this->description) ? $this->description->getData() : null,
            'recurring_id' => $this->recurringId ?? null,
            'google_analytics' => $this->googleAnalytics ? $this->googleAnalytics->getData() : null,
            'second_chance' => $this->secondChance ? $this->secondChance->getData() : null,
            'customer' => ($this->customer) ? $this->customer->getData() : null,
            'delivery' => $this->delivery ? $this->delivery->getData() : null,
            'shopping_cart' => $this->shoppingCart ? $this->shoppingCart->getData() : null,
            'days_active' => $this->daysActive,
            'seconds_active' => $this->secondsActive,
            'checkout_options' => $this->getCheckoutOptions(),
            'plugin' => $this->pluginDetails ? $this->pluginDetails->getData() : null
        ];
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (!$this->pluginDetails) {
            throw new InvalidArgumentException('Required plugin details are missing');
        }

        return true;
    }

    /**
     * @return array
     */
    private function getCheckoutOptions(): array
    {
        if ($this->taxTable) {
            return [
                'tax_tables' => $this->taxTable->getData()
            ];
        }

        return [];
    }
}
