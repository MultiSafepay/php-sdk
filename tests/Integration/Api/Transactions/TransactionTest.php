<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    use DirectOrderRequestFixture;
    use PaymentOptionsFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use IdealGatewayInfoFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;
    use PluginDetailsFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * Test the simple data transfer of a transaction object
     */
    public function testGetOrderData(): void
    {
        $requestDirectOrder = $this->createOrderIdealDirectRequestFixture();
        $transaction = new TransactionResponse($requestDirectOrder->getData());

        $data = $transaction->getData();
        $this->assertArrayHasKey('type', $data, var_export($data, true));
    }
}
