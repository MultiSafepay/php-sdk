<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\CustomerDetails;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\PaymentOptions;
use MultiSafepay\Api\Transactions\RequestOrder\SecondChance;

/**
 * Class RequestOrderDirect
 * @package MultiSafepay\Api\Transactions
 */
class RequestOrderDirect implements RequestOrderInterface
{
    /**
     * @var string
     */
    protected $type = 'direct';

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var Money
     */
    private $money;

    /**
     * @var PaymentOptions
     */
    private $paymentOptions;

    /**
     * @var CustomerDetails
     */
    private $customerDetails;

    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var GatewayInfo|null
     */
    private $gatewayInfo;

    /**
     * @var string
     */
    private $description;

    /**
     * @var SecondChance|null
     */
    private $secondChance;

    /**
     * @var GoogleAnalytics|null
     */
    private $googleAnalytics;

    /**
     * RequestOrderDirect constructor.
     * @param string $orderId
     * @param Money $money
     * @param PaymentOptions $paymentOptions
     * @param CustomerDetails $customerDetails
     * @param string $gatewayCode
     * @param GatewayInfo|null $gatewayInfo
     * @param Description $description
     * @param SecondChance|null $secondChance
     * @param GoogleAnalytics|null $googleAnalytics
     */
    public function __construct(
        string $orderId,
        Money $money,
        PaymentOptions $paymentOptions,
        CustomerDetails $customerDetails,
        string $gatewayCode = '',
        GatewayInfo $gatewayInfo = null,
        Description $description = null,
        SecondChance $secondChance = null,
        GoogleAnalytics $googleAnalytics = null
    ) {
        $this->orderId = $orderId;
        $this->money = $money;
        $this->paymentOptions = $paymentOptions;
        $this->customerDetails = $customerDetails;
        $this->gatewayCode = strtoupper($gatewayCode);
        $this->gatewayInfo = $gatewayInfo;
        $this->description = $description;
        $this->secondChance = $secondChance;
        $this->googleAnalytics = $googleAnalytics;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'gateway' => $this->gatewayCode,
            'currency' => (string) $this->money->getCurrency(),
            'amount' => (string) $this->money->getAmount() * 100,
            'payment_options' => $this->paymentOptions->getData(),
            'customer' => $this->customerDetails->getData(),
            'gateway_info' => $this->gatewayInfo->getData() ?? null,
            'description' => $this->description->getData() ?? null,
            'google_analytics' => $this->googleAnalytics->getData() ?? null,
            'second_chance' => $this->secondChance->getData() ?? null,
        ];
    }
}
