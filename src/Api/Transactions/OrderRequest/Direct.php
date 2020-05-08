<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;

/**
 * Class Direct
 * @package MultiSafepay\Api\Transactions\OrderRequest
 */
class Direct extends OrderRequest
{
    /**
     * @var string
     */
    protected $type = 'direct';

    /**
     * @var CustomerDetails
     */
    private $customerDetails;

    /**
     * @var string
     */
    private $recurringId;

    /**
     * @var SecondChance|null
     */
    private $secondChance;

    /**
     * @var GoogleAnalytics|null
     */
    private $googleAnalytics;

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data['recurring_id'] = $this->recurringId ?? null;
        $data['google_analytics'] = $this->googleAnalytics ? $this->googleAnalytics->getData() : null;
        $data['second_chance'] = $this->secondChance ? $this->secondChance->getData() : null;
        $data['customer'] = ($this->customerDetails) ? $this->customerDetails->getData() : null;

        return $data;
    }

    /**
     * @param CustomerDetails $customerDetails
     * @return Direct
     */
    public function addCustomerDetails(CustomerDetails $customerDetails): Direct
    {
        $this->customerDetails = $customerDetails;
        return $this;
    }

    /**
     * @param string $recurringId
     * @return Direct
     */
    public function addRecurringId(string $recurringId): Direct
    {
        $this->recurringId = $recurringId;
        return $this;
    }

    /**
     * @param SecondChance $secondChance
     * @return Direct
     */
    public function addSecondChance(SecondChance $secondChance): Direct
    {
        $this->secondChance = $secondChance;
        return $this;
    }

    /**
     * @param GoogleAnalytics $googleAnalytics
     * @return Direct
     */
    public function addGoogleAnalytics(GoogleAnalytics $googleAnalytics): Direct
    {
        $this->googleAnalytics = $googleAnalytics;
        return $this;
    }
}
