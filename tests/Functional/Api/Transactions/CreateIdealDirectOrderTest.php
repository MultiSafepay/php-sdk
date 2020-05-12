<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use Psr\Http\Client\ClientExceptionInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;

/**
 * Class CreateIdealDirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateIdealDirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use PluginDetailsFixture;
    use GoogleAnalyticsFixture;
    use AddressFixture;
    use IdealGatewayInfoFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateIdealDirectOrder()
    {
        $orderRequest = $this->createOrderRequest();

        try {
            $response = $this->getClient()->createPostRequest('orders', $orderRequest);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails());
            return;
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['order_id']);
        $this->assertNotEmpty($data['created']);
        $this->assertEquals(0, $data['amount_refunded']);
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return (new OrderRequest())
            ->addType('direct')
            ->addOrderId((string)time())
            ->addMoney(Money::EUR(20))
            ->addGatewayCode(Gateway::IDEAL)
            ->addGatewayInfo($this->createRandomIdealGatewayInfoFixture($this->getApi()))
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
