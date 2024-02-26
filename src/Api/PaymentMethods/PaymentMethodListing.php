<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\PaymentMethods;

use MultiSafepay\Exception\InvalidDataInitializationException;

class PaymentMethodListing
{
    /**
     * @var array
     */
    private $paymentMethods;

    /**
     * Transaction constructor.
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $paymentMethods = [];
        if (!empty($data)) {
            foreach ($data as $paymentMethodData) {
                $paymentMethods[] = new PaymentMethod($paymentMethodData);
            }
        }
        $this->paymentMethods = $paymentMethods;
    }

    /**
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        $paymentMethods = [];
        /** @var PaymentMethod $paymentMethod */
        foreach ($this->paymentMethods as $paymentMethod) {
            $paymentMethods[] = $paymentMethod->getData();
        }
        return $paymentMethods;
    }
}
