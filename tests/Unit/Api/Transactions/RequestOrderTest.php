<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use InvalidArgumentException;
use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class RequestOrderTest extends TestCase
{
    /**
     * Test if regular creation of an order works
     */
    public function testRegularInitialization()
    {
        $requestOrder = new RequestOrder();
        $data = $requestOrder->getData();
        $this->assertEquals('direct', $data['type'], var_export($data, true));

        $requestOrder->addType('redirect');
        $requestOrder->addGateway('custom');
        $requestOrder->addOrderId('1234');
        $requestOrder->addMoney(Money::EUR(200));
        $requestOrder->addDescription('Bedankt vor die bloemen');

        $data = $requestOrder->getData();
        $this->assertEquals('redirect', $data['type']);
        $this->assertEquals('custom', $data['gateway']);
        $this->assertEquals('1234', $data['order_id']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('200', $data['amount']);
        $this->assertEquals('Bedankt vor die bloemen', $data['description']);
    }

    /**
     * Test order creation with wrong type
     */
    public function testInitializationWithWrongType()
    {
        $this->expectException(InvalidArgumentException::class);
        $requestOrder = new RequestOrder();
        $requestOrder->addType('wrong');
    }
}
