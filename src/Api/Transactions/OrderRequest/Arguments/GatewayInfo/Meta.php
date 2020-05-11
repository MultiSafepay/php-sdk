<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class Meta
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Meta implements GatewayInfoInterface
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
     * @var array
     */
    private $data = [];

    /**
     * @param Date $birthday
     * @return Meta
     */
    public function addBirthday(Date $birthday): Meta
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @param BankAccount $bankAccount
     * @return Meta
     */
    public function addBankAccount(BankAccount $bankAccount): Meta
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * @param PhoneNumber $phone
     * @return Meta
     */
    public function addPhone(PhoneNumber $phone): Meta
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param EmailAddress $emailAddress
     * @return Meta
     */
    public function addEmailAddress(EmailAddress $emailAddress): Meta
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @param Gender $gender
     * @return Meta
     */
    public function addGender(Gender $gender): Meta
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param array $data
     * @return Meta
     */
    public function addData(array $data = []): Meta
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = [
            'birthday' => $this->birthday ? $this->birthday->get() : null,
            'bankaccount' => $this->bankAccount ? $this->bankAccount->get() : null,
            'phone' => $this->phone ? $this->phone->get() : null,
            'email' => $this->emailAddress ? $this->emailAddress->get() : null,
            'gender' => $this->gender ? $this->gender->get() : null,
        ];

        $data = array_merge($data, $this->data);

        return $data;
    }
}
