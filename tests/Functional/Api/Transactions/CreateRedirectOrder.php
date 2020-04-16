<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Tests\Fixtures\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateRedirectOrder
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateRedirectOrder extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use OrderRedirectFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateRedirectOrder()
    {
        $requestOrder = $this->createOrderRedirectRequestFixture();

        $response = $this->getClient()->createPostRequest('orders', $requestOrder->getData());
        $data = $response->getResponseData();
        $this->assertEquals('1234', $data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }
}
