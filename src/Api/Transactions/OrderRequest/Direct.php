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
        $data['google_analytics'] = $this->googleAnalytics->getData() ?? null;
        $data['second_chance'] = $this->secondChance->getData() ?? null;
        $data['customer'] = ($this->customerDetails) ? $this->customerDetails->getData() : null;

        return $data;
    }

    /**
     * @param CustomerDetails $customerDetails
     */
    public function addCustomerDetails(CustomerDetails $customerDetails): void
    {
        $this->customerDetails = $customerDetails;
    }

    /**
     * @param string $recurringId
     */
    public function addRecurringId(string $recurringId): void
    {
        $this->recurringId = $recurringId;
    }

    /**
     * @param SecondChance $secondChance
     */
    public function addSecondChance(SecondChance $secondChance): void
    {
        $this->secondChance = $secondChance;
    }

    /**
     * @param GoogleAnalytics $googleAnalytics
     */
    public function addGoogleAnalytics(GoogleAnalytics $googleAnalytics): void
    {
        $this->googleAnalytics = $googleAnalytics;
    }
}
