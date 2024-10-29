<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api\Integration\Transactions;

use MultiSafepay\Api\Transactions\UpdateRequest;
use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class UpdateRequestTest extends TestCase
{
    /**
     * @var UpdateRequest
     */
    private $updateRequest;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->updateRequest = new UpdateRequest();
    }

    /**
     * Test the addId method
     */
    public function testAddId(): void
    {
        $this->updateRequest->addId('123');
        $this->assertEquals('123', $this->updateRequest->getData()['id']);
    }

    /**
     * Test the addStatus method
     */
    public function testAddStatus(): void
    {
        $this->updateRequest->addStatus('status');
        $this->assertEquals('status', $this->updateRequest->getData()['status']);
    }

    /**
     * Test the excludeOrder method
     */
    public function testExcludeOrder(): void
    {
        $this->updateRequest->excludeOrder(true);
        $this->assertEquals(true, $this->updateRequest->getData()['exclude_order']);
    }

    /**
     * Test the extendExpiration method
     */
    public function testExtendExpiration(): void
    {
        $this->updateRequest->extendExpiration(true);
        $this->assertEquals(true, $this->updateRequest->getData()['extend_expiration']);
    }

    /**
     * Test the addReason method
     */
    public function testAddReason(): void
    {
        $this->updateRequest->addReason('reason');
        $this->assertEquals('reason', $this->updateRequest->getData()['reason']);
    }

    /**
     * Test the addPartialShipmentAmount method
     */
    public function testAddPartialShipmentAmount(): void
    {
        $this->updateRequest->addPartialShipmentAmount(new Money(100, 'EUR'));
        $this->assertEquals(100, $this->updateRequest->getData()['partial_shipment_amount']);
    }

    /**
     * Test the addCarrier method
     */
    public function testAddCarrier(): void
    {
        $this->updateRequest->addCarrier('carrier');
        $this->assertEquals('carrier', $this->updateRequest->getData()['carrier']);
    }

    /**
     * Test the addInvoiceId method
     */
    public function testAddInvoiceId(): void
    {
        $this->updateRequest->addInvoiceId('invoice123');
        $this->assertEquals('invoice123', $this->updateRequest->getData()['invoice_id']);
    }

    /**
     * Test the addInvoiceUrl method
     */
    public function testAddInvoiceUrl(): void
    {
        $this->updateRequest->addInvoiceUrl('http://invoice.url');
        $this->assertEquals('http://invoice.url', $this->updateRequest->getData()['invoice_url']);
    }

    /**
     * Test the addPONumber method
     */
    public function testAddPONumber(): void
    {
        $this->updateRequest->addPONumber('PO123');
        $this->assertEquals('PO123', $this->updateRequest->getData()['po_number']);
    }

    /**
     * Test the addShipDate method
     */
    public function testAddShipDate(): void
    {
        $this->updateRequest->addShipDate('2022-01-01');
        $this->assertEquals('2022-01-01', $this->updateRequest->getData()['ship_date']);
    }

    /**
     * Test the addTrackTraceCode method
     */
    public function testAddTrackTraceCode(): void
    {
        $this->updateRequest->addTrackTraceCode('TT123');
        $this->assertEquals('TT123', $this->updateRequest->getData()['tracktrace_code']);
    }

    /**
     * Test the addTrackTraceUrl method
     */
    public function testAddTrackTraceUrl(): void
    {
        $this->updateRequest->addTrackTraceUrl('http://tracktrace.url');
        $this->assertEquals('http://tracktrace.url', $this->updateRequest->getData()['tracktrace_url']);
    }

    /**
     * Test the addNewOrderId method
     */
    public function testAddNewOrderId(): void
    {
        $this->updateRequest->addNewOrderId('newOrder123');
        $this->assertEquals('newOrder123', $this->updateRequest->getData()['new_order_id']);
    }
}
