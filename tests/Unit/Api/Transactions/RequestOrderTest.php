<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Tests\Fixtures\AddressFixture;
use MultiSafepay\Tests\Fixtures\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderDirectFixture;
use MultiSafepay\Tests\Fixtures\OrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class RequestOrderTest extends TestCase
{
    use OrderRedirectFixture;
    use OrderDirectFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use PaymentOptionsFixture;

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
        $this->assertEquals('Foobar', $data['description']);
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
        $this->assertEquals('Foobar', $data['description']);
    }
}