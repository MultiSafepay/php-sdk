<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Functional;

use Exception;
use MultiSafepay\Api\PaymentMethods\PaymentMethod;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;

class GetPaymentMethodsTest extends AbstractTestCase
{
    /**
     * @throws ClientExceptionInterface
     */
    public function testGetPaymentMethods()
    {
        $response = $this->getClient()->createGetRequest('json/payment-methods');
        $data = $response->getResponseData();

        foreach ($data as $paymentMethod) {
            $this->assertIsArray($paymentMethod);
            $this->assertNotEmpty($paymentMethod[PaymentMethod::ID_KEY]);
            $this->assertNotEmpty($paymentMethod[PaymentMethod::NAME_KEY]);
            $this->assertNotEmpty($paymentMethod[PaymentMethod::ALLOWED_AMOUNT_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::ALLOWED_CURRENCIES_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::BRANDS_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::PREFERRED_COUNTRIES_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::REQUIRED_CUSTOMER_DATA_KEY]);
            $this->assertIsBool($paymentMethod[PaymentMethod::SHOPPING_CART_REQUIRED_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::APPS_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::TOKENIZATION_KEY]);
            $this->assertNotEmpty($paymentMethod[PaymentMethod::TYPE_KEY]);
            $this->assertIsArray($paymentMethod[PaymentMethod::ICON_URLS_KEY]);
        }
    }


    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllPaymentMethodsWithoutCoupons()
    {
        $response = $this->getClient()->createGetRequest('json/payment-methods');
        $data = $response->getResponseData();

        $couponFound = false;
        foreach ($data as $paymentMethod) {
            if ($paymentMethod['type'] === 'coupon') {
                $couponFound = true;
            }
        }

        $this->assertFalse($couponFound);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllPaymentMethodsWithCoupons()
    {
        $response = $this->getClient()->createGetRequest('json/payment-methods', ['include_coupons' => '1']);
        $data = $response->getResponseData();

        $couponFound = false;
        foreach ($data as $paymentMethod) {
            if ($paymentMethod['type'] === 'coupon') {
                $couponFound = true;
            }
        }

        $this->assertTrue($couponFound);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetPaymentMethodsWithWrongPath()
    {
        $this->expectException(ApiException::class);
        $this->getClient()->createGetRequest('json/gateways-wrong');
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetPaymentMethodByCode()
    {
        $response = $this->getClient()->createGetRequest('json/payment-methods/VISA');
        $paymentMethod = $response->getResponseData();

        $this->assertIsArray($paymentMethod);
        $this->assertNotEmpty($paymentMethod[PaymentMethod::ID_KEY]);
        $this->assertNotEmpty($paymentMethod[PaymentMethod::NAME_KEY]);
        $this->assertNotEmpty($paymentMethod[PaymentMethod::ALLOWED_AMOUNT_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::ALLOWED_CURRENCIES_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::BRANDS_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::PREFERRED_COUNTRIES_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::REQUIRED_CUSTOMER_DATA_KEY]);
        $this->assertIsBool($paymentMethod[PaymentMethod::SHOPPING_CART_REQUIRED_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::APPS_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::TOKENIZATION_KEY]);
        $this->assertNotEmpty($paymentMethod[PaymentMethod::TYPE_KEY]);
        $this->assertIsArray($paymentMethod[PaymentMethod::ICON_URLS_KEY]);
    }
}
