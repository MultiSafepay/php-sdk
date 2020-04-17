<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder;
use MultiSafepay\Tests\Fixtures\AddressFixture;
use MultiSafepay\Tests\Fixtures\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderDirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateDirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateDirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use OrderDirectFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateRedirectOrder()
    {
        $requestOrder = $this->createOrderDirectRequestFixture();

        $response = $this->getClient()->createPostRequest('orders', $requestOrder->getData());
        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['order_id']);
        $this->assertNotEmpty($data['created']);
        $this->assertEquals(0, $data['amount_refunded']);
    }
}
