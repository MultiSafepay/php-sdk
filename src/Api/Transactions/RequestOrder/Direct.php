<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\RequestOrderInterface;

/**
 * Class Direct
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class Direct implements RequestOrderInterface
{
    const TYPE = 'direct';

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
    private $recurringId;

    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var GatewayInfoInterface|null
     */
    private $gatewayInfo;

    /**
     * @var Description
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
     * Direct constructor.
     * @param string $orderId
     * @param Money $money
     * @param PaymentOptions $paymentOptions
     * @param CustomerDetails $customerDetails
     * @param string $recurringId
     * @param string $gatewayCode
     * @param GatewayInfoInterface|null $gatewayInfo
     * @param Description $description
     * @param SecondChance|null $secondChance
     * @param GoogleAnalytics|null $googleAnalytics
     */
    public function __construct(
        string $orderId,
        Money $money,
        PaymentOptions $paymentOptions,
        CustomerDetails $customerDetails,
        string $recurringId = null,
        string $gatewayCode = null,
        GatewayInfoInterface $gatewayInfo = null,
        Description $description = null,
        SecondChance $secondChance = null,
        GoogleAnalytics $googleAnalytics = null
    ) {
        $this->orderId = $orderId;
        $this->money = $money;
        $this->paymentOptions = $paymentOptions;
        $this->customerDetails = $customerDetails;
        $this->recurringId = $recurringId;
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
            'type' => self::TYPE,
            'order_id' => $this->orderId,
            'gateway' => $this->gatewayCode,
            'recurring_id' => $this->recurringId ?? null,
            'currency' => (string) $this->money->getCurrency(),
            'amount' => (string) ((float)$this->money->getAmount() * 100),
            'payment_options' => $this->paymentOptions->getData(),
            'customer' => $this->customerDetails->getData(),
            'gateway_info' => $this->gatewayInfo->getData() ?? null,
            'description' => $this->description->getData() ?? null,
            'google_analytics' => $this->googleAnalytics->getData() ?? null,
            'second_chance' => $this->secondChance->getData() ?? null,
        ];
    }
}
