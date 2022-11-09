<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentOptionsTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class PaymentOptionsTest extends TestCase
{
    /**
     * Validate the input of notification URL
     */
    public function testNotificationUrl()
    {
        $paymentOptions = new PaymentOptions();
        $paymentOptions->addNotificationUrl('http://example.org/');
        $data = $paymentOptions->getData();
        $this->assertEquals('http://example.org/', $paymentOptions->getNotificationUrl());
        $this->assertEquals('http://example.org/', $data['notification_url']);
    }

    /**
     * Validate the right input of notification method
     */
    public function testNotificationMethod()
    {
        $paymentOptions = new PaymentOptions();
        $this->assertEquals('POST', $paymentOptions->getNotificationMethod());
        $data = $paymentOptions->getData();
        $this->assertEquals('POST', $data['notification_method']);

        $paymentOptions->addNotificationMethod('GET');
        $this->assertEquals('GET', $paymentOptions->getNotificationMethod());
        $data = $paymentOptions->getData();
        $this->assertEquals('GET', $data['notification_method']);
    }

    /**
     * validate the wrong input of notification method
     */
    public function testWrongNotificationMethod()
    {
        $this->expectException(InvalidArgumentException::class);
        $paymentOptions = new PaymentOptions();
        $paymentOptions->addNotificationMethod('FOOBAR');
    }

    /**
     * Validate the input of redirect URL
     */
    public function testRedirectUrl()
    {
        $paymentOptions = new PaymentOptions();
        $paymentOptions->addRedirectUrl('http://example.org/');
        $this->assertEquals('http://example.org/', $paymentOptions->getRedirectUrl());
        $data = $paymentOptions->getData();
        $this->assertEquals('http://example.org/', $data['redirect_url']);
    }

    /**
     * Validate the input of cancel URL
     */
    public function testCancelUrl()
    {
        $paymentOptions = new PaymentOptions();
        $paymentOptions->addCancelUrl('http://example.org/');
        $this->assertEquals('http://example.org/', $paymentOptions->getCancelUrl());
        $data = $paymentOptions->getData();
        $this->assertEquals('http://example.org/', $data['cancel_url']);
    }

    /**
     * Validate the input of close-window flag
     */
    public function testCloseWindow()
    {
        $paymentOptions = new PaymentOptions();
        $paymentOptions->addCloseWindow(true);
        $this->assertTrue($paymentOptions->isCloseWindow());
        $data = $paymentOptions->getData();
        $this->assertTrue($data['close_window']);

        $paymentOptions->addCloseWindow(false);
        $this->assertFalse($paymentOptions->isCloseWindow());
        $data = $paymentOptions->getData();
        $this->assertFalse($data['close_window']);
    }
}
