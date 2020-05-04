<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class GatewayInfoMeta
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfoMeta implements GatewayInfoInterface
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
     * GatewayInfoBankTransfer constructor.
     * @param Date $birthday
     * @param string $bankAccount
     * @param string $phone
     * @param EmailAddress $emailAddress
     * @param Gender|null $gender
     */
    public function __construct(
        ?Date $birthday = null,
        string $bankAccount = '',
        string $phone = '',
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
            'birthday' => $this->birthday->get(),
            'bankaccount' => $this->bankAccount,
            'phone' => $this->phone,
            'email' => $this->emailAddress->get()
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
