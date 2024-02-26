<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class Meta
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 *
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
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
     * @param string $birthday
     * @return Meta
     */
    public function addBirthdayAsString(string $birthday): Meta
    {
        $this->birthday = new Date($birthday);
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
     * @param string $bankAccount
     * @return Meta
     */
    public function addBankAccountAsString(string $bankAccount): Meta
    {
        $this->bankAccount = new BankAccount($bankAccount);
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
     * @param string $phone
     * @return Meta
     */
    public function addPhoneAsString(string $phone): Meta
    {
        $this->phone = new PhoneNumber($phone);
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
     * @param string $emailAddress
     * @return Meta
     * @throws InvalidArgumentException
     */
    public function addEmailAddressAsString(string $emailAddress): Meta
    {
        $this->emailAddress = new EmailAddress($emailAddress);
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
     * @param string $gender
     * @return Meta
     * @throws InvalidArgumentException
     */
    public function addGenderAsString(string $gender): Meta
    {
        $this->gender = new Gender($gender);
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
