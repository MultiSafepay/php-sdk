<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as RequestOrderDirectFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RequestOrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class RequestOrderTest extends TestCase
{
    use GenericOrderRequestFixture;
    use RequestOrderRedirectFixture;
    use RequestOrderDirectFixture;
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
        $requestOrder = $this->createIdealOrderRedirectRequestFixture();

        $data = $requestOrder->getData();
        $this->assertEquals('redirect', $data['type']);
        $this->assertEquals(Gateway::IDEAL, $data['gateway']);
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
        $requestOrder = $this->createOrderIdealDirectRequestFixture();

        $data = $requestOrder->getData();
        $this->assertEquals('direct', $data['type']);
        $this->assertEquals(Gateway::IDEAL, $data['gateway']);
        $this->assertIsNumeric($data['order_id']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('2000', $data['amount']);
        $this->assertEquals('foobar', $data['description']);
    }
}
