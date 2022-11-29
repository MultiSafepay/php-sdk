<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Integration\Api;

use Exception;
use MultiSafepay\Api\PaymentMethodManager;
use MultiSafepay\Api\PaymentMethods\PaymentMethod;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class PaymentMethodManagerTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class PaymentMethodManagerTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAll()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-methods');

        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethods = $paymentMethodManager->getPaymentMethods();

        $this->assertNotEmpty($paymentMethods);

        /** @var PaymentMethod $paymentMethod */
        foreach ($paymentMethods as $paymentMethod) {
            $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllAsArray()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-methods');

        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethods = $paymentMethodManager->getPaymentMethodsAsArray();

        $this->assertIsArray($paymentMethods);

        foreach ($paymentMethods as $paymentMethod) {
            $this->assertIsArray($paymentMethod);
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllWithNoData()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-methods-empty');

        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethods = $paymentMethodManager->getPaymentMethods();

        $this->assertCount(0, $paymentMethods);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetSpecific()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-method-ideal');

        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethod = $paymentMethodManager->getByGatewayCode('IDEAL');

        $this->assertEquals('IDEAL', $paymentMethod->getId());
        $this->assertEquals('iDEAL', $paymentMethod->getName());
        $this->assertEquals('payment-method', $paymentMethod->getType());

        $mediumIconUrl = 'https://testmedia.multisafepay.com/img/methods/2x/ideal.png';
        $this->assertEquals($mediumIconUrl, $paymentMethod->getMediumIconUrl());

        $largeIconUrl = 'https://testmedia.multisafepay.com/img/methods/3x/ideal.png';
        $this->assertEquals($largeIconUrl, $paymentMethod->getLargeIconUrl());

        $vectorIconUrl = 'https://testmedia.multisafepay.com/img/methods/svg/ideal.svg';
        $this->assertEquals($vectorIconUrl, $paymentMethod->getVectorIconUrl());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetByCodeWithWrongCode()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([], false, 1023, 'No gateway (payment method) available');

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1023);
        $this->expectExceptionMessage('No gateway (payment method) available');

        $gateways = new PaymentMethodManager($mockClient);
        $gateways->getByGatewayCode('WRONG');
    }
}
