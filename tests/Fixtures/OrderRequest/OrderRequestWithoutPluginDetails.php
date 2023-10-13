<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest;

/**
 * Trait GenericOrderRequestFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait OrderRequestWithoutPluginDetails
{
    /**
     * @return OrderRequest
     */
    public function createOrderRequestWithoutPluginDetails(): OrderRequest
    {
        $customer = $this->createCustomerDetailsFixture();
        return (new OrderRequest())
            ->addOrderId((string)time())
            ->addDescription($this->createDescriptionFixture())
            ->addCustomer($customer)
            ->addDelivery($customer);
    }
}
