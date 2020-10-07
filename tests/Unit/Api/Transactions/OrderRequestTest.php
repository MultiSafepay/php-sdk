<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions;

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
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class OrderRequestTest extends TestCase
{
    use GenericOrderRequestFixture;
    use DirectOrderRequestFixture;
    use RedirectOrderRequestFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use PaymentOptionsFixture;
    use DescriptionFixture;
    use PluginDetailsFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;
    use CountryFixture;
    use PhoneNumberFixture;

    /**
     * Test if regular creation of an order works
     */
    public function testRequestOrderWithTypeRedirect()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();

        $data = $orderRequest->getData();
        $this->assertEquals('redirect', $data['type']);
        $this->assertEquals(GatewayFixture::IDEAL, $data['gateway']);
        $this->assertIsNumeric($data['order_id']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('2000', $data['amount']);
        $this->assertEquals('foobar', $data['description']);
    }

    /**
     * Test if regular creation of an order works
     */
    public function testRequestOrderWithTypeDirect()
    {
        $orderRequest = $this->createOrderIdealDirectRequestFixture();

        $data = $orderRequest->getData();
        $this->assertEquals('direct', $data['type']);
        $this->assertEquals(GatewayFixture::IDEAL, $data['gateway']);
        $this->assertIsNumeric($data['order_id']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('20', $data['amount']);
        $this->assertEquals('foobar', $data['description']);
    }
}
