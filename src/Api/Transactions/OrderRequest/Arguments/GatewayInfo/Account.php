<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\IbanNumber;

/**
 * Class Account
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Account implements GatewayInfoInterface
{
    /**
     * @var IbanNumber
     */
    private $accountId;

    /**
     * @var string
     */
    private $accountHolderName;

    /**
     * @var IbanNumber
     */
    private $accountHolderIban;

    /**
     * @var string
     */
    private $emandate;

    /**
     * @param IbanNumber $accountId
     * @return Account
     */
    public function addAccountId(IbanNumber $accountId): Account
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @param string $accountId
     * @return Account
     * @throws InvalidArgumentException
     */
    public function addAccountIdAsString(string $accountId): Account
    {
        $this->accountId = new IbanNumber($accountId);
        return $this;
    }

    /**
     * @param string $accountHolderName
     * @return Account
     */
    public function addAccountHolderName(string $accountHolderName): Account
    {
        $this->accountHolderName = $accountHolderName;
        return $this;
    }

    /**
     * @param IbanNumber $accountHolderIban
     * @return Account
     */
    public function addAccountHolderIban(IbanNumber $accountHolderIban): Account
    {
        $this->accountHolderIban = $accountHolderIban;
        return $this;
    }

    /**
     * @param string $accountHolderIban
     * @return Account
     * @throws InvalidArgumentException
     */
    public function addAccountHolderIbanAsString(string $accountHolderIban): Account
    {
        $this->accountHolderIban = new IbanNumber($accountHolderIban);
        return $this;
    }

    /**
     * @param string $emandate
     * @return Account
     */
    public function addEmandate(string $emandate): Account
    {
        $this->emandate = $emandate;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'account_id' => $this->accountId ? $this->accountId->get() : null,
            'account_holder_iban' => $this->accountHolderIban ? $this->accountHolderIban->get() : null,
            'account_holder_name' => $this->accountHolderName,
            'emandate' => $this->emandate,
        ];
    }
}
