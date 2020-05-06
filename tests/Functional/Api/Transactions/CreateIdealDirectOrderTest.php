<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\DirectFixture as RequestOrderDirectFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateIdealDirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateIdealDirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use RequestOrderDirectFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateIdealDirectOrder()
    {
        $requestOrder = $this->createOrderIdealDirectRequestFixture();

        try {
            $response = $this->getClient()->createPostRequest('orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($requestOrder->getData()));
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['order_id']);
        $this->assertNotEmpty($data['created']);
        $this->assertEquals(0, $data['amount_refunded']);
    }
}
