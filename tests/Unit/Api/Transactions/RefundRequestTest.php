<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions;

use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RedirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class RefundRequestTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class RefundRequestTest extends TestCase
{
    /**
     * @covers RefundRequest::getData
     */
    public function testGetData()
    {
        $refundRequest = new RefundRequest(['foo' => 'bar']);
        $data = $refundRequest->getData();
        $this->assertSame('bar', $data['foo']);
    }

    /**
     * @covers RefundRequest::addMoney
     */
    public function testAddMoney()
    {
        $refundRequest = new RefundRequest();
        $refundRequest->addMoney(new Money(42, 'EUR'));
        $data = $refundRequest->getData();
        $this->assertSame(42, $data['amount']);
    }

    /**
     * @covers RefundRequest::addMoney
     */
    public function testAddMoneyFloat()
    {
        $refundRequest = new RefundRequest();
        $refundRequest->addMoney(new Money(151.70 * 100, 'EUR'));
        $data = $refundRequest->getData();
        $this->assertSame(15170, $data['amount']);
    }
}
