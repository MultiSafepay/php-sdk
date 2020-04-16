<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use InvalidArgumentException;
use Money\Money;
use MultiSafepay\Api\Base;
use MultiSafepay\Api\Transactions\RequestOrder\CustomerDetails;

/**
 * Class RequestOrder
 * @package MultiSafepay\Api\Transactions
 */
class RequestOrder extends Base\RequestBody
{
    const ALLOWED_TYPES = ['direct', 'redirect'];

    /**
     * RequestOrder constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->addInitialData();
        parent::__construct($data);
    }

    /**
     * Add initial data
     */
    private function addInitialData()
    {
        $this->addType('direct');
    }

    /**
     * @param string $type
     */
    public function addType(string $type)
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('Type "' . $type . '" is not allowed');
        }

        $this->addData(['type' => $type]);
    }

    /**
     * @param string $orderId
     */
    public function addOrderId(string $orderId)
    {
        $this->addData(['order_id' => $orderId]);
    }

    /**
     * @param string $gateway
     * @todo Add validation of whether the gateway is correct?
     */
    public function addGateway(string $gateway)
    {
        $this->addData(['gateway' => $gateway]);
    }

    /**
     * @param Money $money
     */
    public function addMoney(Money $money)
    {
        $this->addData(['currency' => $money->getCurrency(), 'amount' => $money->getAmount()]);
    }

    /**
     * @param string $description
     */
    public function addDescription(string $description)
    {
        $this->addData(['description' => $description]);
    }

    /**
     * @param PaymentOptions $paymentOptions
     */
    public function addPaymentOptions(PaymentOptions $paymentOptions)
    {
        $this->addData(['payment_options' => $paymentOptions->getData()]);
    }

    /**
     * @param CustomerDetails $customer
     */
    public function addCustomerDetails(CustomerDetails $customer)
    {
        $this->addData(['customer' => $customer->getData()]);
    }

    /**
     * @param bool $sendEmail
     */
    public function addSecondChance(bool $sendEmail)
    {
        $this->addData(['second_chance' => ['send_email' => $sendEmail]]);
    }
}
