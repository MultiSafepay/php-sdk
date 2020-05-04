<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use MultiSafepay\ValueObject\Creditcard\CardNumber;
use MultiSafepay\ValueObject\Creditcard\Cvc;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class GatewayInfoCreditcard
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfoCreditcard implements GatewayInfoInterface
{
    /**
     * @var CardNumber
     */
    private $cardNumber;

    /**
     * @var string
     */
    private $cardHolderName;

    /**
     * @var Date
     */
    private $cardExpiryDate;

    /**
     * @var Cvc
     */
    private $cvc;
    /**
     * @var bool
     */
    private $flexible3d;

    /**
     * GatewayInfoCreditcard constructor.
     * @param CardNumber $cardNumber
     * @param string $cardHolderName
     * @param Date $cardExpiryDate
     * @param Cvc $cvc
     * @param bool $flexible3d
     */
    public function __construct(
        CardNumber $cardNumber,
        string $cardHolderName,
        Date $cardExpiryDate,
        Cvc $cvc,
        bool $flexible3d = false
    ) {
        $this->cardNumber = $cardNumber;
        $this->cardHolderName = $cardHolderName;
        $this->cardExpiryDate = $cardExpiryDate;
        $this->cvc = $cvc;
        $this->flexible3d = $flexible3d;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'card_number' => $this->cardNumber->get(),
            'cart_holder_name' => $this->cardHolderName,
            'cart_expiry_date' => $this->cardExpiryDate->get(),
            'cvc' => $this->cvc->get(),
            'card_cvc' => $this->cvc->get(),
            'flexible_3d' => $this->flexible3d
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleTypes(): array
    {
        return [
            'redirect'
        ];
    }
}
