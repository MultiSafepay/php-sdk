<?php declare(strict_types=1);
namespace Functional\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidApiKeyException;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\AffiliateFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\ValueObject\Money;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateAffiliateOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateAffiliateOrderTest extends AbstractTestCase
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
    use AffiliateFixture;

    /**
     * @throws ClientExceptionInterface
     * @throws InvalidApiKeyException
     * @throws InvalidArgumentException
     */
    public function testCreateAffiliateOrder()
    {
        $orderRequest = $this->createOrderRequest();

        try {
            $response = $this->getClient()->createPostRequest('json/orders', $orderRequest);
        } catch (ApiException $apiException) {
            $this->fail($apiException->getDetails());
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @return OrderRequest
     * @throws InvalidArgumentException
     */
    private function createOrderRequest(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('redirect')
            ->addMoney(new Money(200, 'EUR'))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addAffiliate($this->createAffiliateFixture($this->getPartnerAccountId()));
    }
}
