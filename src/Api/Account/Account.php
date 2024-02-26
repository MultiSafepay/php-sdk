<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Account;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class Account
 *
 * @package MultiSafepay\Api\Account
 */
class Account
{
    public const ACCOUNT_ID_PARAM_NAME = 'account_id';
    public const ROLE_PARAM_NAME = 'role';
    public const SITE_ID_PARAM_NAME = 'site_id';

    /**
     * @var int
     */
    private $accountId;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $siteId;

    /**
     * Account constructor.
     *
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->accountId = $data['account_id'];
        $this->role = $data['role'];
        $this->siteId = $data['site_id'];
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            self::ACCOUNT_ID_PARAM_NAME => $this->getAccountId(),
            self::ROLE_PARAM_NAME => $this->getRole(),
            self::SITE_ID_PARAM_NAME => $this->getSiteId(),
        ];
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->siteId;
    }

    /**
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): void
    {
        if (!isset($data['account_id'], $data['role'], $data['site_id']) || !$data['account_id']) {
            throw new InvalidDataInitializationException('No account data was provided.');
        }
    }
}
