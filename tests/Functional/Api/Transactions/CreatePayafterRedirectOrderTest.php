<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Http\Client\Common\HttpAsyncClientDecorator;
use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as RedirectOrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CheckoutOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
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
 * Class CreatePayafterRedirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreatePayafterRedirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use TaxTableFixture;
    use MetaGatewayInfoFixture;
    use PluginDetailsFixture;
    use PhoneNumberFixture;
    use DescriptionFixture;
    use CheckoutOptionsFixture;
    use CountryFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterRedirectOrder()
    {
        $requestOrder = $this->createOrderRequest();

        try {
            $response = $this->getClient()->createPostRequest('orders', $requestOrder);
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
        return (new OrderRequest())
            ->addType('redirect')
            ->addMoney(Money::EUR(10000))
            ->addOrderId((string)time())
            ->addGatewayCode(Gateway::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addCustomer($this->createRandomCustomerDetailsFixture())
            ->addDelivery($this->createRandomCustomerDetailsFixture())
            ->addCheckoutOptions($this->createCheckoutOptionsFixture())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addShoppingCart($this->createShoppingCartFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
