<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class QrCode
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class QrCode implements GatewayInfoInterface
{
    /**
     * @var int
     */
    private $qrSize = 250;

    /**
     * @var bool
     */
    private $allowMultiple = false;

    /**
     * @var bool
     */
    private $allowChangeAmount = false;

    /**
     * @var int
     */
    private $minAmount;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * @param int $qrSize
     * @return QrCode
     */
    public function addQrSize(int $qrSize): QrCode
    {
        $this->qrSize = $qrSize;
        return $this;
    }

    /**
     * @param bool $allowMultiple
     * @return QrCode
     */
    public function addAllowMultiple(bool $allowMultiple): QrCode
    {
        $this->allowMultiple = $allowMultiple;
        return $this;
    }

    /**
     * @param bool $allowChangeAmount
     * @return QrCode
     */
    public function addAllowChangeAmount(bool $allowChangeAmount): QrCode
    {
        $this->allowChangeAmount = $allowChangeAmount;
        return $this;
    }

    /**
     * @param int $minAmount
     * @return QrCode
     */
    public function addMinAmount(int $minAmount): QrCode
    {
        $this->minAmount = $minAmount;
        return $this;
    }

    /**
     * @param int $maxAmount
     * @return QrCode
     */
    public function addMaxAmount(int $maxAmount): QrCode
    {
        $this->maxAmount = $maxAmount;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'qr_size' => $this->qrSize,
            'allow_multiple' => $this->allowMultiple,
            'allow_change_amount' => $this->allowChangeAmount,
            'min_amount' => $this->minAmount ?? null,
            'max_amount' => $this->maxAmount ?? null,
        ];
    }
}
