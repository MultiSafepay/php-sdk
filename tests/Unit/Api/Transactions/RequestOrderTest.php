<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as RequestOrderDirectFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RequestOrderRedirectFixture;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class RequestOrderTest extends TestCase
{
    use RequestOrderRedirectFixture;
    use RequestOrderDirectFixture;
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
