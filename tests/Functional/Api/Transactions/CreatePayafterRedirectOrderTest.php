<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Http\Client\Common\HttpAsyncClientDecorator;
use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as RedirectOrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
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
    use DescriptionFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterRedirectOrder()
    {
        $requestOrder = $this->getPayafterOrderRedirectRequestFixture();

        try {
            $response = $this->getClient()->createPostRequest('orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($requestOrder->getData()));
            return;
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @return RedirectOrderRequest
     */
    public function getPayafterOrderRedirectRequestFixture(): RedirectOrderRequest
    {
        $faker = FakerFactory::create();
        $requestOrder = (new RedirectOrderRequest())
            ->addMoney(Money::EUR(100))
            ->addOrderId((string)time())
            ->addGatewayCode(Gateway::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addCustomer($this->createRandomCustomerDetailsFixture())
            ->addDelivery($this->createRandomCustomerDetailsFixture())
            ->addTaxTable($this->createTaxTableFixture())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addShoppingCart($this->createShoppingCartFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());

        return $requestOrder;
    }
}
