<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\ValueObject\Money;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Transactions
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class UpdateRequest extends RequestBody
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var bool
     */
    private $excludeOrder;

    /**
     * @var bool
     */
    private $extendExpiration;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var Money
     */
    private $partialShipmentAmount;

    /**
     * @var string
     */
    private $carrier;

    /**
     * @var string
     */
    private $invoiceId;

    /**
     * @var string
     */
    private $invoiceUrl;

    /**
     * @var string
     */
    private $poNumber;

    /**
     * @var string
     */
    private $shipDate;

    /**
     * @var string
     */
    private $trackTraceCode;

    /**
     * @var string
     */
    private $trackTraceUrl;

    /**
     * @var string
     */
    private $newOrderId;

    /**
     * @return array
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getData(): array
    {
        return $this->removeNullRecursive(
            array_merge(
                [
                    'id' => $this->id ?: null,
                    'status' => $this->status ?: null,
                    'exclude_order' => $this->excludeOrder ?: null,
                    'extend_expiration' => $this->extendExpiration ?: null,
                    'reason' => $this->reason ?: null,
                    'partial_shipment_amount' => $this->partialShipmentAmount
                        ? (int)round($this->partialShipmentAmount->getAmount()) : null,
                    'carrier' =>$this->carrier ?: null,
                    'invoice_id' => $this->invoiceId ?: null,
                    'invoice_url' => $this->invoiceUrl ?: null,
                    'po_number' => $this->poNumber ?: null,
                    'ship_date' => $this->shipDate ?: null,
                    'tracktrace_code' => $this->trackTraceCode ?: null,
                    'tracktrace_url' => $this->trackTraceUrl ?: null,
                    'new_order_id' => $this->newOrderId ?: null,
                ],
                $this->data
            )
        );
    }

    /**
     * @param string $id
     * @return UpdateRequest
     */
    public function addId(string $id): UpdateRequest
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $status
     * @return UpdateRequest
     */
    public function addStatus(string $status): UpdateRequest
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param bool $excludeOrder
     * @return UpdateRequest
     */
    public function excludeOrder(bool $excludeOrder): UpdateRequest
    {
        $this->excludeOrder = $excludeOrder;
        return $this;
    }

    /**
     * @param bool $extendExpiration
     * @return UpdateRequest
     */
    public function extendExpiration(bool $extendExpiration): UpdateRequest
    {
        $this->extendExpiration = $extendExpiration;
        return $this;
    }

    /**
     * @param string $reason
     * @return UpdateRequest
     */
    public function addReason(string $reason): UpdateRequest
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @param Money $partialShipmentAmount
     * @return $this
     */
    public function addPartialShipmentAmount(Money $partialShipmentAmount): UpdateRequest
    {
        $this->partialShipmentAmount = $partialShipmentAmount;
        return $this;
    }

    /**
     * @param string $carrier
     * @return $this
     */
    public function addCarrier(string $carrier): UpdateRequest
    {
        $this->carrier = $carrier;
        return $this;
    }

    /**
     * @param string $invoiceId
     * @return $this
     */
    public function addInvoiceId(string $invoiceId): UpdateRequest
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    /**
     * @param string $invoiceUrl
     * @return $this
     */
    public function addInvoiceUrl(string $invoiceUrl): UpdateRequest
    {
        $this->invoiceUrl = $invoiceUrl;
        return $this;
    }

    /**
     * @param string $poNumber
     * @return $this
     */
    public function addPONumber(string $poNumber): UpdateRequest
    {
        $this->poNumber = $poNumber;
        return $this;
    }

    /**
     * @param string $shipDate
     * @return $this
     */
    public function addShipDate(string $shipDate): UpdateRequest
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    /**
     * @param string $trackTraceCode
     * @return $this
     */
    public function addTrackTraceCode(string $trackTraceCode): UpdateRequest
    {
        $this->trackTraceCode = $trackTraceCode;
        return $this;
    }

    /**
     * @param string $trackTraceUrl
     * @return $this
     */
    public function addTrackTraceUrl(string $trackTraceUrl): UpdateRequest
    {
        $this->trackTraceUrl = $trackTraceUrl;
        return $this;
    }

    /**
     * @param string $newOrderId
     * @return $this
     */
    public function addNewOrderId(string $newOrderId): UpdateRequest
    {
        $this->newOrderId = $newOrderId;
        return $this;
    }
}
