<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Redirect\GatewayInfo\Meta as MetaGatewayInfo;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as RedirectOrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
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

        $requestOrder = new RedirectOrderRequest(
            (string)time(),
            Money::EUR(100),
            Gateway::PAYAFTER,
            $this->getMetaGatewayInfoFixture(),
            $this->createPaymentOptionsFixture()
        );

        $requestOrder->addCustomer($this->createRandomCustomerDetailsFixture());
        $requestOrder->addDelivery($this->createRandomCustomerDetailsFixture());
        $requestOrder->addTaxTable($this->createTaxTableFixture());
        $requestOrder->addDescription(new Description($faker->sentence));
        $requestOrder->addShoppingCart($this->createShoppingCartFixture());
        $requestOrder->addPluginDetails(new PluginDetails('Foobar', '0.0.1'));

        return $requestOrder;
    }

    /**
     * @return MetaGatewayInfo
     */
    private function getMetaGatewayInfoFixture()
    {
        $faker = FakerFactory::create();

        return new MetaGatewayInfo(
            new Date('17 december 2001'),
            new BankAccount('0417164300'),
            new PhoneNumber($faker->phoneNumber),
            new EmailAddress($faker->email)
        );
    }
}
