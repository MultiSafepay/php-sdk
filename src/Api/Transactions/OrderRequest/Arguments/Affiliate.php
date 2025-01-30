<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate\SplitPayment;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Affiliate
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class Affiliate
{
    /**
     * @var SplitPayment[]
     */
    private $splitPayments;

    /**
     * Affiliate constructor.
     * @param SplitPayment[] $splitPayments
     */
    public function __construct(array $splitPayments = [])
    {
        $this->splitPayments = $splitPayments;
    }

    /**
     * @param SplitPayment[] $splitPayments
     * @return Affiliate
     */
    public function addSplitPayments(array $splitPayments): Affiliate
    {
        $this->splitPayments = $splitPayments;
        return $this;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        return [
            'split_payments' => array_map(function (SplitPayment $splitPayment) {
                return $splitPayment->getData();
            }, $this->splitPayments),
        ];
    }
}
