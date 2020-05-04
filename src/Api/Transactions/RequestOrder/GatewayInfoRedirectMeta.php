<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class GatewayInfoRedirectMeta
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfoRedirectMeta implements GatewayInfoInterface
{
    /**
     * @var Date
     */
    private $birthday;

    /**
     * @var BankAccount
     */
    private $bankAccount;

    /**
     * @var PhoneNumber
     */
    private $phoneNumber;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var Gender
     */
    private $gender;

    /**
     * GatewayInfoBankTransfer constructor.
     * @param Date|null $birthday
     * @param BankAccount|null $bankAccount
     * @param PhoneNumber|null $phoneNumber
     * @param EmailAddress|null $emailAddress
     * @param Gender|null $gender
     */
    public function __construct(
        ?Date $birthday = null,
        ?BankAccount $bankAccount = null,
        ?PhoneNumber $phoneNumber = null,
        ?EmailAddress $emailAddress = null,
        ?Gender $gender = null
    ) {
        $this->birthday = $birthday;
        $this->bankAccount = $bankAccount;
        $this->phoneNumber = $phoneNumber;
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
            'phone' => $this->phoneNumber->get() ?? null,
            'email' => $this->emailAddress->get() ?? null
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
            'PAYAFTER',
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
