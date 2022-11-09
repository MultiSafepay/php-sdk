<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidTotalAmountException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CheckoutOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartWithTaxFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\ValueObject\Money;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreatePayafterDirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreatePayafterDirectOrderTest extends AbstractTestCase
{
    use GenericOrderRequestFixture;
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use ShoppingCartWithTaxFixture;
    use TaxTableFixture;
    use MetaGatewayInfoFixture;
    use PluginDetailsFixture;
    use DescriptionFixture;
    use CheckoutOptionsFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterDirectOrder()
    {
        try {
            $requestOrder = $this->createOrderRequest();
            $response = $this->getClient()->createPostRequest('json/orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails());
            return;
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterDirectOrderWithAmountMismatchButAccepted()
    {
        try {
            $requestOrder = $this->createOrderRequestWithTax();
            $response = $this->getClient()->createPostRequest('json/orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails());
            return;
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterDirectOrderWithAmountMismatch()
    {
        $this->expectException(InvalidTotalAmountException::class);
        $requestOrder = $this->createOrderRequestWithTax();
        $this->getClient()->useStrictMode(true)->createPostRequest('json/orders', $requestOrder);
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addMoney(new Money(10000, 'EUR'))
            ->addGatewayCode(GatewayFixture::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addShoppingCart($this->createShoppingCartFixture());
    }

    /**
     * @return OrderRequest
     * @note The total amount of items 1887.60 which causes an exception in the strict mode
     */
    private function createOrderRequestWithTax(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addMoney(new Money(1887, 'EUR'))
            ->addGatewayCode(GatewayFixture::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addShoppingCart($this->createRandomShoppingCartWithTaxFixture());
    }
}
