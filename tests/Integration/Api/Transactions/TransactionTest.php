<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Tests\Fixtures\AddressFixture;
use MultiSafepay\Tests\Fixtures\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderDirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    use OrderDirectFixture;
    use PaymentOptionsFixture;
    use CustomerDetailsFixture;
    use AddressFixture;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $requestDirectOrder = $this->createOrderIdealDirectRequestFixture();
        $transaction = new Transaction($requestDirectOrder->getData());

        $data = $transaction->getData();
        $this->assertArrayHasKey('type', $data, var_export($data, true));
    }
}
