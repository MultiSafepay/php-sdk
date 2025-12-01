<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\ValueObject\Amount;

/**
 * Class CaptureRequest
 * @package MultiSafepay\Api\Transactions
 */
class CaptureRequest extends RequestBody
{
    public const CAPTURE_MANUAL_TYPE = 'manual';

    /**
     * @var string
     */
    private $newOrderId;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var string
     */
    private $newOrderStatus;

    /**
     * @var string
     */
    private $invoiceId;

    /**
     * @var string
     */
    private $trackTraceCode;

    /**
     * @var string
     */
    private $carrier;
    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $description;
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive(
            array_merge(
                [
                    'amount' => $this->amount->get() ?? null,
                    'new_order_id' => $this->newOrderId ?: null,
                    'new_order_status' => $this->newOrderStatus ?: 'completed',
                    'invoice_id' => $this->invoiceId ?: null,
                    'tracktrace_code' => $this->trackTraceCode ?: null,
                    'carrier' =>$this->carrier ?: null,
                    'reason' => $this->reason ?: null,
                    'description' => $this->description ?: null,
                ],
                $this->data
            )
        );
    }

    /**
     * @param Amount $amount
     * @return CaptureRequest
     */
    public function addAmount(Amount $amount): CaptureRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $newOrderId
     * @return CaptureRequest
     */
    public function addNewOrderId(string $newOrderId): CaptureRequest
    {
        $this->newOrderId = $newOrderId;
        return $this;
    }

    /**
     * @param string $newOrderStatus
     * @return CaptureRequest
     */
    public function addNewOrderStatus(string $newOrderStatus): CaptureRequest
    {
        $this->newOrderStatus = $newOrderStatus;
        return $this;
    }

    /**
     * @param string $invoiceId
     * @return CaptureRequest
     */
    public function addInvoiceId(string $invoiceId): CaptureRequest
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    /**
     * @param string $trackTraceCode
     * @return CaptureRequest
     */
    public function addTrackTraceCode(string $trackTraceCode): CaptureRequest
    {
        $this->trackTraceCode = $trackTraceCode;
        return $this;
    }

    /**
     * @param string $carrier
     * @return CaptureRequest
     */
    public function addCarrier(string $carrier): CaptureRequest
    {
        $this->carrier = $carrier;
        return $this;
    }

    /**
     * @param string $reason
     * @return CaptureRequest
     */
    public function addReason(string $reason): CaptureRequest
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @param string $description
     * @return CaptureRequest
     */
    public function addDescription(string $description): CaptureRequest
    {
        $this->description = $description;
        return $this;
    }
}
