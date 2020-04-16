<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use InvalidArgumentException;
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

        $requestOrder = new RequestOrder();
        $requestOrder->addType('redirect');
        $data = $requestOrder->getData();
        $this->assertEquals('redirect', $data['type'], var_export($data, true));
    }

    /**
     * Test wrong order creation
     */
    public function testWrongInitialization()
    {
        $this->expectException(InvalidArgumentException::class);
        $requestOrder = new RequestOrder();
        $requestOrder->addType('wrong');
    }
}
