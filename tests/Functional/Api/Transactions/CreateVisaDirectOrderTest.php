<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CheckoutOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CreditCardGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
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
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateVisaDirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateVisaDirectOrderTest extends AbstractTestCase
{
    use GenericOrderRequestFixture;
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use ShoppingCartWithTaxFixture;
    use TaxTableFixture;
    use CreditCardGatewayInfoFixture;
    use PluginDetailsFixture;
    use DescriptionFixture;
    use CheckoutOptionsFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateVisaDirectOrder()
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
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addAmount(new Amount(10000))
            ->addCurrency(new Currency('EUR'))
            ->addGatewayCode(GatewayFixture::VISA)
            ->addGatewayInfo($this->createCreditCardGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture());
    }
}
