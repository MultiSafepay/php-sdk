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
     * @return void
     */
    public function testGetData()
    {
        $amount = new Amount(1000, 'EUR');
        $captureRequest = new CaptureRequest();

        $captureRequest
            ->addAmount($amount)
            ->addNewOrderId('12345')
            ->addNewOrderStatus('shipped')
            ->addInvoiceId('INV-001')
            ->addTrackTraceCode('TR-123')
            ->addCarrier('PostNL')
            ->addReason('Customer request')
            ->addDescription('Partial capture')
            ->addShipDate('2023-10-01');

        $data = $captureRequest->getData();

        $this->assertSame(1000, $data['amount']);
        $this->assertSame('12345', $data['new_order_id']);
        $this->assertSame('shipped', $data['new_order_status']);
        $this->assertSame('INV-001', $data['invoice_id']);
        $this->assertSame('TR-123', $data['tracktrace_code']);
        $this->assertSame('PostNL', $data['carrier']);
        $this->assertSame('Customer request', $data['reason']);
        $this->assertSame('Partial capture', $data['description']);
        $this->assertSame('2023-10-01', $data['ship_date']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\CaptureRequest::addAmount
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
     * @covers \MultiSafepay\Api\Transactions\CaptureRequest::addAmount
     */
    public function testAlwaysCompleted()
    {
        $captureRequest = new CaptureRequest();
        $captureRequest->addAmount(new Amount(42));
        $data = $captureRequest->getData();
        $this->assertSame('completed', $data['new_order_status']);
    }
}
