<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Direct\GatewayInfo;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrderDirect;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class Meta
 * @package MultiSafepay\Api\Transactions\RequestOrder\Direct\GatewayInfo
 */
class Meta implements GatewayInfoInterface
{
    /**
     * @var Date
     */
    private $birthday;

    /**
     * @var string
     */
    private $bankAccount;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var Gender|null
     */
    private $gender;

    /**
     * Meta constructor.
     * @param Date $birthday
     * @param BankAccount $bankAccount
     * @param PhoneNumber $phone
     * @param EmailAddress $emailAddress
     * @param Gender|null $gender
     */
    public function __construct(
        ?Date $birthday = null,
        ?BankAccount $bankAccount = null,
        ?PhoneNumber $phone = null,
        ?EmailAddress $emailAddress = null,
        ?Gender $gender = null
    ) {
        $this->birthday = $birthday;
        $this->bankAccount = $bankAccount;
        $this->phone = $phone;
        $this->emailAddress = $emailAddress;
        $this->gender = $gender;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'birthday' => $this->birthday->get() ?? null,
            'bankaccount' => $this->bankAccount->get() ?? null,
            'phone' => $this->phone->get() ?? null,
            'email' => $this->emailAddress->get() ?? null,
            'gender' => $this->emailAddress->get() ?? null,
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
            Gateway::AFTERPAY,
            Gateway::EINVOICE,
            Gateway::PAYAFTER,
            Gateway::SANTANDER,
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleTypes(): array
    {
        return [
            RequestOrderDirect::TYPE
        ];
    }
}
