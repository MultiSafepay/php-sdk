<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Creditcard\CardNumber;
use MultiSafepay\ValueObject\Creditcard\Cvc;
use MultiSafepay\ValueObject\Date;

/**
 * Class Creditcard
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Creditcard implements GatewayInfoInterface
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
     * @var string
     */
    private $termUrl;

    /**
     * @param CardNumber $cardNumber
     * @return Creditcard
     */
    public function addCardNumber(CardNumber $cardNumber): Creditcard
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @param string $cardNumber
     * @return Creditcard
     * @throws InvalidArgumentException
     */
    public function addCardNumberAsString(string $cardNumber): Creditcard
    {
        $this->cardNumber = new CardNumber($cardNumber);
        return $this;
    }

    /**
     * @param string $cardHolderName
     * @return Creditcard
     */
    public function addCardHolderName(string $cardHolderName): Creditcard
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    /**
     * @param Date $cardExpiryDate
     * @return Creditcard
     */
    public function addCardExpiryDate(Date $cardExpiryDate): Creditcard
    {
        $this->cardExpiryDate = $cardExpiryDate;
        return $this;
    }

    /**
     * @param string $cardExpiryDate
     * @return Creditcard
     */
    public function addCardExpiryDateAsString(string $cardExpiryDate): Creditcard
    {
        $this->cardExpiryDate = new Date($cardExpiryDate);
        return $this;
    }

    /**
     * @param Cvc $cvc
     * @return Creditcard
     */
    public function addCvc(Cvc $cvc): Creditcard
    {
        $this->cvc = $cvc;
        return $this;
    }

    /**
     * @param string $cvc
     * @return Creditcard
     * @throws InvalidArgumentException
     */
    public function addCvcAsString(string $cvc): Creditcard
    {
        $this->cvc = new Cvc($cvc);
        return $this;
    }

    /**
     * @param bool $flexible3d
     * @return Creditcard
     */
    public function addFlexible3d(bool $flexible3d): Creditcard
    {
        $this->flexible3d = $flexible3d;
        return $this;
    }

    /**
     * @param string $termUrl
     * @return Creditcard
     */
    public function addTermUrl(string $termUrl): Creditcard
    {
        $this->termUrl = $termUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'card_number' => $this->cardNumber ? $this->cardNumber->get() : null,
            'card_holder_name' => $this->cardHolderName,
            'card_expiry_date' => $this->cardExpiryDate ? $this->cardExpiryDate->get('ym') : null,
            'cvc' => $this->cvc ? $this->cvc->get() : null,
            'card_cvc' => $this->cvc ? $this->cvc->get() : null,
            'flexible_3d' => $this->flexible3d,
            'term_url' => $this->termUrl,
        ];
    }
}
