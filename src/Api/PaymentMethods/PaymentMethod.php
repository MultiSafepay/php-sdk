<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\PaymentMethods;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class PaymentMethod
 * @package MultiSafepay\Api\PaymentMethod
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 * phpcs:disable ObjectCalisthenics.Files.FunctionLength
 */
class PaymentMethod
{
    public const ID_KEY = 'id';
    public const NAME_KEY = 'name';
    public const TYPE_KEY = 'type';
    public const BRANDS_KEY = 'brands';
    public const ALLOWED_AMOUNT_KEY = 'allowed_amount';
    public const ALLOWED_MIN_AMOUNT_KEY = 'min';
    public const ALLOWED_MAX_AMOUNT_KEY = 'max';
    public const ALLOWED_CURRENCIES_KEY = 'allowed_currencies';
    public const APPS_KEY = 'apps';
    public const TOKENIZATION_KEY = 'tokenization';
    public const TOKENIZATION_MODELS_KEY = 'models';
    public const IS_ENABLED_KEY = 'is_enabled';
    public const SHOPPING_CART_REQUIRED_KEY = 'shopping_cart_required';
    public const PREFERRED_COUNTRIES_KEY = 'preferred_countries';
    public const ALLOWED_COUNTRIES_KEY = 'allowed_countries';
    public const ICON_URLS_KEY = 'icon_urls';
    public const ICON_URLS_LARGE_KEY = 'large';
    public const ICON_URLS_MEDIUM_KEY = 'medium';
    public const ICON_URLS_VECTOR_KEY = 'vector';
    public const REQUIRED_CUSTOMER_DATA_KEY = 'required_customer_data';
    public const PAYMENT_COMPONENT_KEY = 'payment_components';
    public const PAYMENT_COMPONENT_HAS_FIELDS_KEY = 'has_fields';
    public const PAYMENT_COMPONENT_QR_KEY = 'qr';
    public const FAST_CHECKOUT_KEY = 'fastcheckout';
    public const RECURRING_MODEL_CARD_ON_FILE_KEY = 'cardonfile';
    public const RECURRING_MODEL_SUBSCRIPTION_KEY = 'subscription';
    public const RECURRING_MODEL_UNSCHEDULED_KEY = 'unscheduled';
    public const SUPPORTED_KEY = 'supported';

    public const COUPON_TYPE = 'coupon';
    public const PAYMENT_METHOD_TYPE = 'payment-method';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $allowedAmount;

    /**
     * @var array
     */
    private $brands;

    /**
     * @var array
     */
    private $allowedCurrencies;

    /**
     * @var array
     */
    private $apps;

    /**
     * @var array
     */
    private $tokenization;

    /**
     * @var bool
     */
    private $shoppingCartRequired;

    /**
     * @var array
     */
    private $preferredCountries;

    /**
     * @var array
     */
    private $allowedCountries;

    /**
     * @var array
     */
    private $iconUrls;

    /**
     * @var array
     */
    private $requiredCustomerData;

    /**
     * Transaction constructor.
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->id = $data[self::ID_KEY];
        $this->name = $data[self::NAME_KEY];
        $this->type = $data[self::TYPE_KEY];
        $this->brands = $data[self::BRANDS_KEY] ?? '';
        $this->allowedAmount = $data[self::ALLOWED_AMOUNT_KEY] ?? '';
        $this->allowedCurrencies = $data[self::ALLOWED_CURRENCIES_KEY] ?? '';
        $this->apps = $data[self::APPS_KEY] ?? '';
        $this->tokenization = $data[self::TOKENIZATION_KEY] ?? '';
        $this->shoppingCartRequired = $data[self::SHOPPING_CART_REQUIRED_KEY] ?? false;
        $this->preferredCountries = $data[self::PREFERRED_COUNTRIES_KEY] ?? null;
        $this->allowedCountries = $data[self::ALLOWED_COUNTRIES_KEY] ?? null;
        $this->iconUrls = $data[self::ICON_URLS_KEY] ?? '';
        $this->requiredCustomerData = $data[self::REQUIRED_CUSTOMER_DATA_KEY] ?? null;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getBrands(): array
    {
        return (array)$this->brands;
    }

    /**
     * @return float
     */
    public function getMinAmount(): float
    {
        if ($this->getType() === self::COUPON_TYPE) {
            return 0.0;
        }

        return (float)$this->allowedAmount[self::ALLOWED_MIN_AMOUNT_KEY];
    }

    /**
     * @return float|null
     */
    public function getMaxAmount(): ?float
    {
        if ($this->getType() === self::COUPON_TYPE) {
            return null;
        }

        return $this->allowedAmount[self::ALLOWED_MAX_AMOUNT_KEY] ?? null;
    }

    /**
     * @return array
     */
    public function getApps(): array
    {
        return (array)$this->apps;
    }

    /**
     * @return array
     */
    public function getAllowedCurrencies(): array
    {
        return (array)$this->allowedCurrencies;
    }

    /**
     * @return bool
     */
    public function isShoppingCartRequired(): bool
    {
        return $this->shoppingCartRequired;
    }

    /**
     * @return array
     */
    public function getPreferredCountries(): ?array
    {
        return $this->preferredCountries;
    }

    /**
     * @return array
     */
    public function getAllowedCountries(): ?array
    {
        return $this->allowedCountries;
    }

    /**
     * @return array
     */
    public function getIconUrls(): array
    {
        return $this->iconUrls;
    }

    /**
     * @return string
     */
    public function getLargeIconUrl(): string
    {
        return $this->iconUrls[self::ICON_URLS_LARGE_KEY] ?? '';
    }

    /**
     * @return string
     */
    public function getMediumIconUrl(): string
    {
        return $this->iconUrls[self::ICON_URLS_MEDIUM_KEY] ?? '';
    }

    /**
     * @return string
     */
    public function getVectorIconUrl(): string
    {
        return $this->iconUrls[self::ICON_URLS_VECTOR_KEY] ?? '';
    }

    /**
     * @return array
     */
    public function getRequiredCustomerData(): ?array
    {
        return $this->requiredCustomerData;
    }

    /**
     * @return bool
     */
    public function supportsPaymentComponent(): bool
    {
        return isset($this->apps[self::PAYMENT_COMPONENT_KEY]) &&
            $this->apps[self::PAYMENT_COMPONENT_KEY][self::IS_ENABLED_KEY] &&
            ($this->apps[self::PAYMENT_COMPONENT_KEY][self::PAYMENT_COMPONENT_HAS_FIELDS_KEY] ||
            $this->supportsTokenization());
    }

    /**
     * @return bool
     */
    public function supportsQr(): bool
    {
        return isset($this->apps[self::PAYMENT_COMPONENT_KEY]) &&
            $this->apps[self::PAYMENT_COMPONENT_KEY][self::PAYMENT_COMPONENT_QR_KEY][self::SUPPORTED_KEY];
    }

    /**
     * @return bool
     */
    public function supportsFastCheckout(): bool
    {
        return isset($this->apps[self::FAST_CHECKOUT_KEY]) &&
            $this->apps[self::FAST_CHECKOUT_KEY][self::IS_ENABLED_KEY];
    }

    /**
     * @return bool
     */
    public function supportsTokenization(): bool
    {
        return $this->tokenization[self::IS_ENABLED_KEY];
    }

    /**
     * @return bool
     */
    public function supportsTokenizationCardOnFile(): bool
    {
        if (!$this->supportsTokenization()) {
            return false;
        }

        return isset($this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_CARD_ON_FILE_KEY]) &&
            $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_CARD_ON_FILE_KEY];
    }

    /**
     * @return bool
     */
    public function supportsTokenizationSubscription(): bool
    {
        if (!$this->supportsTokenization()) {
            return false;
        }

        return isset($this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_SUBSCRIPTION_KEY]) &&
            $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_SUBSCRIPTION_KEY];
    }

    /**
     * @return bool
     */
    public function supportsTokenizationUnscheduled(): bool
    {
        if (!$this->supportsTokenization()) {
            return false;
        }

        return isset($this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_UNSCHEDULED_KEY]) &&
            $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_UNSCHEDULED_KEY];
    }

    /**
     * @return bool
     */
    public function isCoupon()
    {
        return $this->getType() === self::COUPON_TYPE;
    }

    /**
     * Return an array with the payment method object information
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            self::ID_KEY => $this->id,
            self::NAME_KEY => $this->name,
            self::TYPE_KEY => $this->type,
            self::BRANDS_KEY => $this->brands,
            self::ALLOWED_AMOUNT_KEY => [
                self::ALLOWED_MIN_AMOUNT_KEY => $this->allowedAmount[self::ALLOWED_MIN_AMOUNT_KEY] ?? 0,
                self::ALLOWED_MAX_AMOUNT_KEY => $this->allowedAmount[self::ALLOWED_MAX_AMOUNT_KEY] ?? null,
            ],
            self::ALLOWED_CURRENCIES_KEY => $this->allowedCurrencies,
            self::ALLOWED_COUNTRIES_KEY => $this->allowedCountries,
            self::APPS_KEY => $this->apps,
            self::TOKENIZATION_KEY => [
                self::IS_ENABLED_KEY => $this->tokenization[self::IS_ENABLED_KEY] ?? false,
                self::TOKENIZATION_MODELS_KEY => [
                    self::RECURRING_MODEL_CARD_ON_FILE_KEY => $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_CARD_ON_FILE_KEY] ?? false,
                    self::RECURRING_MODEL_SUBSCRIPTION_KEY => $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_SUBSCRIPTION_KEY]  ?? false,
                    self::RECURRING_MODEL_UNSCHEDULED_KEY => $this->tokenization[self::TOKENIZATION_MODELS_KEY][self::RECURRING_MODEL_UNSCHEDULED_KEY] ?? false,
                ],
            ],
            self::SHOPPING_CART_REQUIRED_KEY => $this->shoppingCartRequired,
            self::PREFERRED_COUNTRIES_KEY => $this->preferredCountries,
            self::ICON_URLS_KEY => [
                self::ICON_URLS_LARGE_KEY => $this->iconUrls[self::ICON_URLS_LARGE_KEY] ?? '',
                self::ICON_URLS_MEDIUM_KEY => $this->iconUrls[self::ICON_URLS_MEDIUM_KEY] ?? '',
                self::ICON_URLS_VECTOR_KEY => $this->iconUrls[self::ICON_URLS_VECTOR_KEY] ?? '',
            ],
            self::REQUIRED_CUSTOMER_DATA_KEY => $this->requiredCustomerData,
        ];
    }

    /**
     * @param array $data
     * @return void
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): void
    {
        if (empty($data[self::ID_KEY])) {
            throw new InvalidDataInitializationException('No ID');
        }

        if (empty($data[self::NAME_KEY])) {
            throw new InvalidDataInitializationException('No Name ' . $data[self::ID_KEY]);
        }

        if (empty($data[self::TYPE_KEY])) {
            throw new InvalidDataInitializationException('No Type ' . $data[self::ID_KEY]);
        }

        if (empty($data[self::ALLOWED_AMOUNT_KEY])) {
            throw new InvalidDataInitializationException('No Allowed Amounts ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::ALLOWED_COUNTRIES_KEY]) || !is_array($data[self::ALLOWED_COUNTRIES_KEY])) {
            throw new InvalidDataInitializationException('No Allowed Countries ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::BRANDS_KEY]) || !is_array($data[self::BRANDS_KEY])) {
            throw new InvalidDataInitializationException('No Brands ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::PREFERRED_COUNTRIES_KEY]) || !is_array($data[self::PREFERRED_COUNTRIES_KEY])) {
            throw new InvalidDataInitializationException('No Preferred Countries ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::REQUIRED_CUSTOMER_DATA_KEY]) || !is_array($data[self::REQUIRED_CUSTOMER_DATA_KEY])) {
            throw new InvalidDataInitializationException('No Required Customer Data ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::SHOPPING_CART_REQUIRED_KEY])) {
            throw new InvalidDataInitializationException('No Shopping Cart Required ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::TOKENIZATION_KEY]) || !is_array($data[self::TOKENIZATION_KEY])) {
            throw new InvalidDataInitializationException('No Tokenization ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::APPS_KEY]) || !is_array($data[self::APPS_KEY])) {
            throw new InvalidDataInitializationException('No Apps ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::APPS_KEY][self::PAYMENT_COMPONENT_KEY]) || !is_array($data[self::APPS_KEY][self::PAYMENT_COMPONENT_KEY])) {
            throw new InvalidDataInitializationException('No Payment Components ' . $data[self::ID_KEY]);
        }

        $paymentComponents = $data[self::APPS_KEY][self::PAYMENT_COMPONENT_KEY];

        if (!isset($paymentComponents[self::PAYMENT_COMPONENT_HAS_FIELDS_KEY])) {
            throw new InvalidDataInitializationException('No Payment Component has "has_fields" field ' . $data[self::ID_KEY]);
        }

        if (!isset($paymentComponents[self::IS_ENABLED_KEY])) {
            throw new InvalidDataInitializationException('No Payment Component has "is_enabled" field ' . $data[self::ID_KEY]);
        }

        if (!isset($paymentComponents[self::PAYMENT_COMPONENT_QR_KEY])) {
            throw new InvalidDataInitializationException('No Payment Component has "qr" field ' . $data[self::ID_KEY]);
        }

        if (!isset($data[self::ICON_URLS_KEY]) || !is_array($data[self::ICON_URLS_KEY])) {
            throw new InvalidDataInitializationException('Icon urls is not an array ' . $data[self::ID_KEY]);
        }
    }
}
