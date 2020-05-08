<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class OrderRequest
 * @package MultiSafepay\Api\Transactions
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
     * @var PluginDetails
     */
    protected $pluginDetails;

    /**
     * OrderRequest constructor.
     * @param string $orderId
     * @param Money $money
     * @param string $gatewayCode
     * @param PaymentOptions $paymentOptions
     * @param GatewayInfoInterface $gatewayInfo
     */
    public function __construct(
        string $orderId,
        Money $money,
        string $gatewayCode, // @todo: Replace this with actual Gateway class
        GatewayInfoInterface $gatewayInfo,
        PaymentOptions $paymentOptions
    ) {
        $this->orderId = $orderId;
        $this->money = $money;
        $this->gatewayCode = $gatewayCode;
        $this->gatewayInfo = $gatewayInfo;
        $this->paymentOptions = $paymentOptions;
    }

    /**
     * @param string $type
     */
    public function addType(string $type)
    {
        $allowedTypes = ['direct', 'redirect'];
        if (!in_array($type, $allowedTypes)) {
            $msg = 'Type "' . $type . '" is not a known type. ';
            $msg .= 'Available types: ' . implode(', ', $allowedTypes);
            throw new InvalidArgumentException($msg);
        }

        $this->type = $type;
    }

    /**
     * @param Description $description
     */
    public function addDescription(Description $description): void
    {
        $this->description = $description;
    }

    /**
     * @param PluginDetails $pluginDetails
     */
    public function addPluginDetails(PluginDetails $pluginDetails): void
    {
        $this->pluginDetails = $pluginDetails;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->validate();

        return [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'currency' => (string)$this->money->getCurrency(),
            'amount' => (string)((float)$this->money->getAmount() * 100),
            'gateway' => $this->gatewayCode,
            'gateway_info' => $this->gatewayInfo->getData(),
            'payment_options' => $this->paymentOptions->getData(),
            'description' => ($this->description) ? $this->description->getData() : null,
            'plugin' => $this->pluginDetails->getData() ?? null,
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
}
