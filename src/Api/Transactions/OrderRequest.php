<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomInfo;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Validators\TotalAmountValidator;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Exception\InvalidTotalAmountException;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\ValueObject\Money;

/**
 * Class OrderRequest
 * @package MultiSafepay\Api\Transactions
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class OrderRequest extends RequestBody implements OrderRequestInterface
{
    public const DIRECT_TYPE = 'direct';
    public const REDIRECT_TYPE = 'redirect';
    public const PAYMENT_LINK_TYPE = 'paymentlink';
    public const ALLOWED_TYPES = [self::DIRECT_TYPE, self::REDIRECT_TYPE, self::PAYMENT_LINK_TYPE];

    /** The allowed values for the recurring models. */
    public const CARD_ON_FILE_MODEL = 'cardOnFile';
    public const SUBSCRIPTION_MODEL = 'subscription';
    public const UNSCHEDULED_MODEL = 'unscheduled';
    public const ALLOWED_RECURRING_MODELS = [self::CARD_ON_FILE_MODEL, self::SUBSCRIPTION_MODEL, self::UNSCHEDULED_MODEL];

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
     * @var string
     */
    private $recurringModel;

    /**
     * @var CustomInfo
     */
    private $customInfo;

    /**
     * @var string
     */
    private $var1;

    /**
     * @var string
     */
    private $var2;

    /**
     * @var string
     */
    private $var3;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @param string $type
     * @return OrderRequest
     * @throws InvalidArgumentException
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
     * @param string $type
     * @return OrderRequest
     * @throws InvalidArgumentException
     */
    public function addRecurringModel(string $type): OrderRequest
    {
        if (!in_array($type, self::ALLOWED_RECURRING_MODELS)) {
            $msg = 'Type "' . $type . '" is not a known type. ';
            $msg .= 'Available types: ' . implode(', ', self::ALLOWED_RECURRING_MODELS);
            throw new InvalidArgumentException($msg);
        }

        $this->recurringModel = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
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
     * @param Amount $amount
     * @return $this
     */
    public function addAmount(Amount $amount): OrderRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param Currency $currency
     * @return $this
     */
    public function addCurrency(Currency $currency): OrderRequest
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        if ($this->money) {
            return $this->money->getCurrency() ?? null;
        }

        if ($this->currency) {
            return $this->currency->get() ?? null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        if ($this->money) {
            return (int)round($this->money->getAmount()) ?? null;
        }

        if ($this->amount) {
            return $this->amount->get() ?? null;
        }

        return null;
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
     * @return string
     */
    public function getGatewayCode(): string
    {
        return $this->gatewayCode;
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
     * @param string $description
     * @return OrderRequest
     */
    public function addDescriptionText(string $description): OrderRequest
    {
        $this->description = (new Description())->addDescription($description);
        return $this;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getDescriptionText(): string
    {
        return $this->description->getData();
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
     * @return PluginDetails|null
     */
    public function getPluginDetails(): ?PluginDetails
    {
        return $this->pluginDetails;
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
     * @throws InvalidArgumentException
     */
    public function addShoppingCart(ShoppingCart $shoppingCart): OrderRequest
    {
        $this->shoppingCart = $shoppingCart;
        if (!$this->checkoutOptions) {
            $checkoutOptions = new CheckoutOptions();
            $checkoutOptions->generateFromShoppingCart($shoppingCart);
            $this->addCheckoutOptions($checkoutOptions);
        }
        return $this;
    }

    /**
     * @return ShoppingCart|null
     */
    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    /**
     * @return GatewayInfoInterface
     */
    public function getGatewayInfo(): GatewayInfoInterface
    {
        return $this->gatewayInfo;
    }

    /**
     * Retrieve the checkout_options object from the OrderRequest
     *
     * @return CheckoutOptions
     */
    public function getCheckoutOptions(): CheckoutOptions
    {
        if (!$this->checkoutOptions) {
            $this->checkoutOptions = new CheckoutOptions();
        }

        return $this->checkoutOptions;
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
     * @param CustomInfo $customInfo
     * @return OrderRequest
     */
    public function addCustomInfo(CustomInfo $customInfo): OrderRequest
    {
        $this->customInfo = $customInfo;
        return $this;
    }

    /**
     * @param string $var1
     * @return OrderRequest
     */
    public function addVar1(string $var1): OrderRequest
    {
        $this->var1 = $var1;
        return $this;
    }

    /**
     * @param string $var2
     * @return OrderRequest
     */
    public function addVar2(string $var2): OrderRequest
    {
        $this->var2 = $var2;
        return $this;
    }

    /**
     * @param string $var3
     * @return OrderRequest
     */
    public function addVar3(string $var3): OrderRequest
    {
        $this->var3 = $var3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVar1(): ?string
    {
        return $this->var1;
    }

    /**
     * @return string|null
     */
    public function getVar2(): ?string
    {
        return $this->var2;
    }

    /**
     * @return string|null
     */
    public function getVar3(): ?string
    {
        return $this->var3;
    }

    /**
     * @return array
     * phpcs:disable ObjectCalisthenics.Files.FunctionLength
     * @throws InvalidArgumentException|InvalidTotalAmountException
     */
    public function getData(): array
    {
        $data = [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'currency' => $this->getCurrency(),
            'amount' => $this->getAmount(),
            'gateway' => $this->gatewayCode,
            'gateway_info' => $this->gatewayInfo ? $this->gatewayInfo->getData() : null,
            'payment_options' => $this->paymentOptions ? $this->paymentOptions->getData() : null,
            'description' => ($this->description) ? $this->description->getData() : null,
            'recurring_id' => $this->recurringId ?? null,
            'recurring_model' => $this->recurringModel ?? null,
            'google_analytics' => $this->googleAnalytics ? $this->googleAnalytics->getData() : null,
            'second_chance' => $this->secondChance ? $this->secondChance->getData() : null,
            'customer' => ($this->customer) ? $this->customer->getData() : null,
            'delivery' => $this->delivery ? $this->delivery->getData() : null,
            'shopping_cart' => $this->shoppingCart ? $this->shoppingCart->getData() : null,
            'checkout_options' => $this->checkoutOptions ? $this->checkoutOptions->getData() : null,
            'days_active' => $this->daysActive,
            'seconds_active' => $this->secondsActive,
            'plugin' => $this->pluginDetails ? $this->pluginDetails->getData() : null,
            'custom_info' => ($this->customInfo) ? $this->customInfo->getData() : null,
            'var1' => $this->getVar1(),
            'var2' => $this->getVar2(),
            'var3' => $this->getVar3(),
        ];

        $data = $this->removeNullRecursive(array_merge($data, $this->data));
        $this->validate($data);

        return $data;
    }

    /**
     * @deprecated since 5.15.0, use Api/Transactions/OrderRequest/Arguments/CheckoutOptions::addCartValidation instead
     * @param array $data
     * @return bool
     * @throws InvalidTotalAmountException
     */
    protected function validate(array $data): bool
    {
        if ($this->strictMode) {
            (new TotalAmountValidator())->validate($data);
        }

        return true;
    }
}
