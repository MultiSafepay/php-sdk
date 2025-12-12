<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Api\Transactions;

use MultiSafepay\Api\Transactions\CaptureRequest;
use MultiSafepay\ValueObject\Amount;
use PHPUnit\Framework\TestCase;

/**
 * Class CaptureRequestTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class CaptureRequestTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\CaptureRequest::getData
     */
    public function testGetData()
    {
        $captureRequest = (new CaptureRequest())
            ->addAmount(new Amount(100))
            ->addNewOrderStatus('completed')
            ->addInvoiceId('ORD-837243')
            ->addReason('Verzonden');
        $data = $captureRequest->getData();
        $this->assertEquals(100, $data['amount']);
        $this->assertEquals('completed', $data['new_order_status']);
        $this->assertEquals('ORD-837243', $data['invoice_id']);
        $this->assertEquals('Verzonden', $data['reason']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\CaptureRequest::addMoney
     */
    public function testAddAmount()
    {
        $captureRequest = new CaptureRequest();
        $captureRequest->addAmount(new Amount(42));
        $data = $captureRequest->getData();
        $this->assertSame(42, $data['amount']);
    }

    /**
     * `completed` is the only allowed `new_order_status` value for this request. So this value should be coerced.
     *
     * @covers \MultiSafepay\Api\Transactions\CaptureRequest::addMoney
     */
    public function testAlwaysCompleted()
    {
        $captureRequest = new CaptureRequest();
        $captureRequest->addAmount(new Amount(42));
        $data = $captureRequest->getData();
        $this->assertSame('completed', $data['new_order_status']);
    }
}
