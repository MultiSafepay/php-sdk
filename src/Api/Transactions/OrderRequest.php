<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class OrderRequest
 * @package MultiSafepay\Api\Transactions
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class OrderRequest extends DataObject implements OrderRequestInterface
{
    const ALLOWED_TYPES = ['direct', 'redirect'];

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
     * @var CheckoutOptions
     */
    protected $checkoutOptions;

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
        if (!in_array($type, self::ALLOWED_TYPES)) {
            $msg = 'Type "' . $type . '" is not a known type. ';
            $msg .= 'Available types: ' . implode(', ', self::ALLOWED_TYPES);
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
     * @param CheckoutOptions $checkoutOptions
     * @return OrderRequest
     */
    public function addCheckoutOptions(CheckoutOptions $checkoutOptions): OrderRequest
    {
        $this->checkoutOptions = $checkoutOptions;
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
        $data = [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'currency' => $this->money ? (string)$this->money->getCurrency() : null,
            'amount' => $this->money ? (int)$this->money->getAmount() : null,
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
            'checkout_options' => $this->checkoutOptions ? $this->checkoutOptions->getData() : null,
            'days_active' => $this->daysActive,
            'seconds_active' => $this->secondsActive,
            'plugin' => $this->pluginDetails ? $this->pluginDetails->getData() : null
        ];

        $data = $this->removeNullRecursive(array_merge($data, $this->data));
        $this->validate($data);

        return $data;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function validate(array $data): bool
    {
        if (!$data['plugin']) {
            throw new InvalidArgumentException('Required plugin details are missing');
        }

        $this->validateShoppingCartTotals($data);

        return true;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function validateShoppingCartTotals(array $data): bool
    {
        if (isset($data['amount']) && isset($data['shopping_cart']) && isset($data['shopping_cart']['items'])) {
            $amount = $data['amount'];
            $totalUnitPrice = 0;
            foreach ($data['shopping_cart']['items'] as $item) {
                $totalUnitPrice = +$item['unit_price'] * $item['quantity'];
            }

            $totalUnitPrice = $totalUnitPrice * 100;
            if ($totalUnitPrice != $amount) {
                $msg = sprintf('Total of unit_price (%s) does not match amount (%s)', $amount, $totalUnitPrice);
                throw new InvalidArgumentException($msg);
            }
        }

        return true;
    }
}
