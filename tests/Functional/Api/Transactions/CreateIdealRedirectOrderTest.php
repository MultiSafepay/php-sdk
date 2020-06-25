<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateIdealRedirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateIdealRedirectOrderTest extends AbstractTestCase
{
    use GenericOrderRequestFixture;
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use TaxTableFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use PluginDetailsFixture;
    use IdealGatewayInfoFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateIdealRedirectOrder()
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
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('redirect')
            ->addMoney(Money::EUR(20))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture());
    }
}
