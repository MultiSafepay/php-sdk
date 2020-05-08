<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
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
     * @return array
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
            'plugin' => $this->pluginDetails ? $this->pluginDetails->getData() : null,
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
