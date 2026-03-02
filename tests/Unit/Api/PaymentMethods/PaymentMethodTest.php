<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\PaymentMethods;

use Exception;
use MultiSafepay\Api\PaymentMethodManager;
use MultiSafepay\Api\PaymentMethods\PaymentMethod;
use MultiSafepay\Exception\InvalidDataInitializationException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

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
     *
     * @throws Exception
     * @throws ClientExceptionInterface
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
     *
     * @throws Exception
     * @throws ClientExceptionInterface
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
     * Test support manual capture from current API format
     */
    public function testSupportsManualCaptureFromRootLevelData()
    {
        $data = $this->getValidData();
        $data[PaymentMethod::MANUAL_CAPTURE_KEY] = [
            PaymentMethod::IS_ENABLED_KEY => true,
            PaymentMethod::SUPPORTED_KEY => true,
        ];

        $paymentMethod = new PaymentMethod($data);

        $this->assertTrue($paymentMethod->supportsManualCapture());
    }

    /**
     * Test manual capture defaults to false when field is missing
     */
    public function testSupportsManualCaptureReturnsFalseWithoutManualCapture()
    {
        $paymentMethod = new PaymentMethod($this->getValidData());

        $this->assertFalse($paymentMethod->supportsManualCapture());
    }

    /**
     * Test manual capture is false when one of required flags is false
     *
     * @dataProvider getManualCaptureFalseValues
     */
    public function testSupportsManualCaptureReturnsFalseWithFalseValues(array $manualCapture)
    {
        $data = $this->getValidData();
        $data[PaymentMethod::MANUAL_CAPTURE_KEY] = $manualCapture;

        $paymentMethod = new PaymentMethod($data);

        $this->assertFalse($paymentMethod->supportsManualCapture());
    }

    /**
     * Test invalid manual capture payload fails initialization
     *
     * @dataProvider getWrongManualCaptureData
     */
    public function testImproperInitializationWithInvalidManualCapture($manualCapture, string $expectedErrorMessage)
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        $data = $this->getValidData();
        $data[PaymentMethod::MANUAL_CAPTURE_KEY] = $manualCapture;

        new PaymentMethod($data);
    }

    /**
     * Test getData includes manual_capture structure when enabled
     */
    public function testGetDataIncludesManualCaptureWhenEnabled()
    {
        $data = $this->getValidData();
        $data[PaymentMethod::MANUAL_CAPTURE_KEY] = [
            PaymentMethod::IS_ENABLED_KEY => true,
            PaymentMethod::SUPPORTED_KEY => true,
        ];

        $paymentMethod = new PaymentMethod($data);
        $result = $paymentMethod->getData();

        $this->assertArrayHasKey(PaymentMethod::MANUAL_CAPTURE_KEY, $result);
        $this->assertIsArray($result[PaymentMethod::MANUAL_CAPTURE_KEY]);
        $this->assertArrayHasKey(PaymentMethod::IS_ENABLED_KEY, $result[PaymentMethod::MANUAL_CAPTURE_KEY]);
        $this->assertArrayHasKey(PaymentMethod::SUPPORTED_KEY, $result[PaymentMethod::MANUAL_CAPTURE_KEY]);
        $this->assertTrue($result[PaymentMethod::MANUAL_CAPTURE_KEY][PaymentMethod::IS_ENABLED_KEY]);
        $this->assertTrue($result[PaymentMethod::MANUAL_CAPTURE_KEY][PaymentMethod::SUPPORTED_KEY]);
    }
    
    /**
     * Test if the wallet payment method is detected from the payload
     *
     * @throws InvalidDataInitializationException
     */
    public function testIsWalletReturnsTrueWhenPayloadMarksWallet()
    {
        $data = $this->getValidData();
        $data[PaymentMethod::IS_WALLET_KEY] = true;
        
        $paymentMethod = new PaymentMethod($data);
        
        $this->assertTrue($paymentMethod->isWallet());
    }
    
    /**
     * Test if a non-wallet payment method is detected from the payload
     *
     * @throws InvalidDataInitializationException
     */
    public function testIsWalletReturnsFalseWhenPayloadDoesNotMarkWallet()
    {
        $paymentMethod = new PaymentMethod($this->getValidData());
        
        $this->assertFalse($paymentMethod->isWallet());
    }
    
    /**
     * Test if wallet defaults to false when payload omits is_wallet
     *
     * @throws InvalidDataInitializationException
     */
    public function testIsWalletReturnsFalseWhenIsWalletKeyIsMissing()
    {
        $data = $this->getValidData();
        unset($data[PaymentMethod::IS_WALLET_KEY]);
        
        $paymentMethod = new PaymentMethod($data);
        
        $this->assertFalse($paymentMethod->isWallet());
    }
    
    /**
     * Test if getData includes wallet flag
     *
     * @throws InvalidDataInitializationException
     */
    public function testGetDataIncludesIsWallet()
    {
        $data = $this->getValidData();
        $data[PaymentMethod::IS_WALLET_KEY] = true;
        
        $paymentMethod = new PaymentMethod($data);
        $result = $paymentMethod->getData();
        
        $this->assertArrayHasKey(PaymentMethod::IS_WALLET_KEY, $result);
        $this->assertTrue($result[PaymentMethod::IS_WALLET_KEY]);
    }

    /**
     * @return array
     */
    private function getWrongData(): array
    {
        $this->wrongData['id'] = '';
        return $this->wrongData;
    }

    /**
     * @return array
     */
    private function getValidData(): array
    {
        return [
            PaymentMethod::ID_KEY => 'VISA',
            PaymentMethod::NAME_KEY => 'Visa',
            PaymentMethod::TYPE_KEY => PaymentMethod::PAYMENT_METHOD_TYPE,
            PaymentMethod::ALLOWED_AMOUNT_KEY => [
                PaymentMethod::ALLOWED_MIN_AMOUNT_KEY => 0,
                PaymentMethod::ALLOWED_MAX_AMOUNT_KEY => null,
            ],
            PaymentMethod::ALLOWED_COUNTRIES_KEY => [],
            PaymentMethod::BRANDS_KEY => [],
            PaymentMethod::PREFERRED_COUNTRIES_KEY => [],
            PaymentMethod::REQUIRED_CUSTOMER_DATA_KEY => [],
            PaymentMethod::SHOPPING_CART_REQUIRED_KEY => false,
            PaymentMethod::TOKENIZATION_KEY => [
                PaymentMethod::IS_ENABLED_KEY => true,
                PaymentMethod::TOKENIZATION_MODELS_KEY => [
                    PaymentMethod::RECURRING_MODEL_CARD_ON_FILE_KEY => true,
                    PaymentMethod::RECURRING_MODEL_SUBSCRIPTION_KEY => true,
                    PaymentMethod::RECURRING_MODEL_UNSCHEDULED_KEY => true,
                ],
            ],
            PaymentMethod::APPS_KEY => [
                PaymentMethod::PAYMENT_COMPONENT_KEY => [
                    PaymentMethod::PAYMENT_COMPONENT_HAS_FIELDS_KEY => true,
                    PaymentMethod::IS_ENABLED_KEY => true,
                    PaymentMethod::PAYMENT_COMPONENT_QR_KEY => [
                        PaymentMethod::SUPPORTED_KEY => false,
                    ],
                ],
                PaymentMethod::FAST_CHECKOUT_KEY => [
                    PaymentMethod::IS_ENABLED_KEY => true,
                ],
            ],
            PaymentMethod::ICON_URLS_KEY => [
                PaymentMethod::ICON_URLS_LARGE_KEY => 'https://example.com/visa-large.png',
                PaymentMethod::ICON_URLS_MEDIUM_KEY => 'https://example.com/visa-medium.png',
                PaymentMethod::ICON_URLS_VECTOR_KEY => 'https://example.com/visa.svg',
            ],
            PaymentMethod::ALLOWED_CURRENCIES_KEY => ['EUR'],
            PaymentMethod::IS_WALLET_KEY => false,
        ];
    }

    /**
     * @return array
     */
    public function getManualCaptureFalseValues(): array
    {
        return [
            [[
                PaymentMethod::IS_ENABLED_KEY => false,
                PaymentMethod::SUPPORTED_KEY => true,
            ]],
            [[
                PaymentMethod::IS_ENABLED_KEY => true,
                PaymentMethod::SUPPORTED_KEY => false,
            ]],
            [[
                PaymentMethod::IS_ENABLED_KEY => false,
                PaymentMethod::SUPPORTED_KEY => false,
            ]],
        ];
    }

    /**
     * @return array
     */
    public function getWrongManualCaptureData(): array
    {
        return [
            ['', 'Manual capture is not an array'],
            [
                [
                    PaymentMethod::SUPPORTED_KEY => true,
                ],
                'No Manual Capture has "is_enabled" field',
            ],
            [
                [
                    PaymentMethod::IS_ENABLED_KEY => true,
                ],
                'No Manual Capture has "supported" field',
            ],
        ];
    }
}
