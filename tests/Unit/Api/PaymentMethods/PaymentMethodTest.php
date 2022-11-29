<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\PaymentMethods;

use MultiSafepay\Api\PaymentMethodManager;
use MultiSafepay\Api\PaymentMethods\PaymentMethod;
use MultiSafepay\Exception\InvalidDataInitializationException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentMethodTest
 * @package MultiSafepay\Tests\Unit\Api\PaymentMethods
 */
class PaymentMethodTest extends TestCase
{
    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     * @var array
     */
    private $wrongData;


    /**
     * Test normal initialization
     */
    public function testNormalInitialization()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-methods');

        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethods = $paymentMethodManager->getPaymentMethods();
        $this->paymentMethod = $paymentMethods[0];
        $this->assertNotEmpty($this->paymentMethod->getId());
        $this->assertNotEmpty($this->paymentMethod->getName());
        $this->assertNotEmpty($this->paymentMethod->getType());
        $this->assertIsArray($this->paymentMethod->getIconUrls());
        $this->assertNotEmpty($this->paymentMethod->getMediumIconUrl());
        $this->assertNotEmpty($this->paymentMethod->getLargeIconUrl());
        $this->assertNotEmpty($this->paymentMethod->getVectorIconUrl());
        $this->assertIsArray($this->paymentMethod->getApps());
        $this->assertIsArray($this->paymentMethod->getAllowedCurrencies());
        $this->assertIsArray($this->paymentMethod->getBrands());
        $this->assertIsArray($this->paymentMethod->getPreferredCountries());
    }

    /**
     * Test wrong initialization
     */
    public function testIncompleteData()
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage('No Preferred Countries');
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('payment-methods-with-wrong-data');
        $paymentMethodManager = new PaymentMethodManager($mockClient);
        $paymentMethods = $paymentMethodManager->getPaymentMethods();
        $this->paymentMethod = $paymentMethods[0];
    }

    /**
     * Test improper initialization
     *
     */
    public function testImproperInitialization()
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage('No ID');
        new PaymentMethod($this->getWrongData());
    }

    /**
     * @return array
     */
    private function getWrongData(): array
    {
        $this->wrongData['id'] = '';
        return $this->wrongData;
    }
}
