<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest;

/**
 * Trait GenericOrderRequestFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait GenericOrderRequestFixture
{
    /**
     * @return OrderRequest
     */
    public function createGenericOrderRequestFixture(): OrderRequest
    {
        $customer = $this->createCustomerDetailsFixture();
        return (new OrderRequest())
            ->addOrderId((string)time())
            ->addDescription($this->createDescriptionFixture())
            ->addCustomer($customer)
            ->addDelivery($customer)
            ->addPluginDetails($this->createPluginDetailsFixture());
    }

    /**
     * @return OrderRequest
     */
    public function createGenericRandomOrderRequestFixture(): OrderRequest
    {
        $customer = $this->createCustomerDetailsFixture();
        return (new OrderRequest())
            ->addOrderId((string)time())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addCustomer($customer)
            ->addDelivery($customer)
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
