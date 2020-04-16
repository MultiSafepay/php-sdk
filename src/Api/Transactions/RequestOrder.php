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
use MultiSafepay\Api\Transactions\RequestOrder\PaymentOptions;
use MultiSafepay\Exception\OrderDataWithWrongTypeException;
use MultiSafepay\ValueObject\Customer;

/**
 * Class RequestOrder
 * @package MultiSafepay\Api\Transactions
 */
class RequestOrder extends Base\RequestBody
{
    const ALLOWED_TYPES = ['direct', 'redirect', 'checkout', 'paymentlink'];

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
     * @param mixed $orderId
     */
    public function addOrderId($orderId)
    {
        $orderId = (string)$orderId;
        $this->addData(['order_id' => $orderId]);
    }

    /**
     * @param string $gateway
     * @todo Add validation of whether the gateway is correct?
     */
    public function addGateway(string $gateway)
    {
        $gateway = strtoupper($gateway);
        $this->addData(['gateway' => $gateway]);
    }

    /**
     * @param array $gatewayInfo
     */
    public function addGatewayInfo(array $gatewayInfo)
    {
        if ($this->get('type') !== 'direct') {
            throw new OrderDataWithWrongTypeException('Method "addGatewayInfo" can only be used with type "direct');
        }

        $this->addData(['gateway_info' => $gatewayInfo]);
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
        if (strlen($description) > 200) {
            throw new InvalidArgumentException('Description can not be more than 200 characters');
        }

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
     * @param Customer $customer
     */
    public function addDelivery(Customer $customer)
    {
        $this->addData(['delivery' => $customer->getData()]);
    }

    /**
     * @param int $recurringId
     */
    public function addRecurringId(int $recurringId)
    {
        if ($this->get('type') !== 'direct') {
            throw new OrderDataWithWrongTypeException('Method "addRecurringId" can only be used with type "direct');
        }

        $this->addData(['recurring_id' => $recurringId]);
    }

    /**
     * @param bool $sendEmail
     */
    public function addSecondChance(bool $sendEmail)
    {
        if ($this->get('type') !== 'redirect') {
            throw new OrderDataWithWrongTypeException('Method "addSecondChance" can only be used with type "redirect');
        }

        $this->addData(['second_chance' => ['send_email' => $sendEmail]]);
    }
}
