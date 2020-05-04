<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Redirect\GatewayInfo\Meta as MetaGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect as RequestOrderRedirect;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect\Payafter;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\TaxTableFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\ShoppingCart;
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
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @return RequestOrderRedirect
     */
    public function getPayafterOrderRedirectRequestFixture(): RequestOrderRedirect
    {
        return new Payafter(
            (string)time(),
            Money::EUR(100), // @todo: Make sure this matches with shopping_cart
            Gateway::PAYAFTER,
            $this->createPaymentOptionsFixture(),
            $this->getMetaGatewayInfoFixture(),
            $this->createCustomerDetailsFixture(),
            $this->createCustomerDetailsFixture(),
            $this->createShoppingCartFixture(), // @todo: Make sure tax_table_selector matches with tax_table
            $this->createTaxTableFixture(),
            new Description('Foobar')
        );
    }

    /**
     * @return ShoppingCart
     * @todo Add a test using this empty cart to trigger ApiException 'Empty shopping cart'
     */
    public function getEmptyShoppingCart()
    {
        return new ShoppingCart([]);
    }

    /**
     * @return MetaGatewayInfo
     */
    private function getMetaGatewayInfoFixture()
    {
        return new MetaGatewayInfo(
            new Date('17 december 2001'),
            new BankAccount('0417164300'),
            new PhoneNumber('0208500500'),
            new EmailAddress('example@multisafepay.com')
        );
    }
}
