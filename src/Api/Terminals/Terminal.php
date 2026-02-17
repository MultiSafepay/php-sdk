<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Terminals;

use MultiSafepay\Api\Base\ResponseBody;
use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class Terminal
 *
 * Represents a POS terminal as returned by the API.
 * The exact fields may evolve; use getData() for forward compatibility.
 */
class Terminal extends ResponseBody
{
    public const ID_KEY = 'id';
    public const PROVIDER_KEY = 'provider';
    public const NAME_KEY = 'name';
    public const CODE_KEY = 'code';
    public const CREATED_KEY = 'created';
    public const LAST_UPDATED_KEY = 'last_updated';
    public const MANUFACTURER_ID_KEY = 'manufacturer_id';
    public const SERIAL_NUMBER_KEY = 'serial_number';
    public const ACTIVE_KEY = 'active';
    public const GROUP_ID_KEY = 'group_id';
    public const COUNTRY_KEY = 'country';

    /**
     * Terminal constructor.
     *
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data = [])
    {
        $this->validate($data);
        parent::__construct($data);
    }

    /**
     * Validate required fields
     *
     * @param array $data
     * @return void
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): void
    {
        if (empty($data[self::ID_KEY])) {
            throw new InvalidDataInitializationException('Missing required field: ID');
        }

        if (empty($data[self::PROVIDER_KEY])) {
            throw new InvalidDataInitializationException('Missing required field: Provider');
        }

        if (empty($data[self::NAME_KEY])) {
            throw new InvalidDataInitializationException('Missing required field: Name');
        }
    }

    /**
     * Get the terminal ID
     *
     * @return string
     */
    public function getId(): string
    {
        return (string)$this->get(self::ID_KEY);
    }

    /**
     * Get the terminal provider
     *
     * @return string
     */
    public function getProvider(): string
    {
        return (string)$this->get(self::PROVIDER_KEY);
    }

    /**
     * Get the terminal name
     *
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->get(self::NAME_KEY);
    }

    /**
     * Get the terminal code
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        $code = $this->get(self::CODE_KEY);
        return $code !== null ? (string)$code : null;
    }

    /**
     * Get the terminal creation date
     *
     * @return string|null
     */
    public function getCreated(): ?string
    {
        $created = $this->get(self::CREATED_KEY);
        return $created !== null ? (string)$created : null;
    }

    /**
     * Get the terminal last updated date
     *
     * @return string|null
     */
    public function getLastUpdated(): ?string
    {
        $lastUpdated = $this->get(self::LAST_UPDATED_KEY);
        return $lastUpdated !== null ? (string)$lastUpdated : null;
    }

    /**
     * Get the terminal manufacturer ID
     *
     * @return string|null
     */
    public function getManufacturerId(): ?string
    {
        $manufacturerId = $this->get(self::MANUFACTURER_ID_KEY);
        return $manufacturerId !== null ? (string)$manufacturerId : null;
    }

    /**
     * Get the terminal serial number
     *
     * @return string|null
     */
    public function getSerialNumber(): ?string
    {
        $serialNumber = $this->get(self::SERIAL_NUMBER_KEY);
        return $serialNumber !== null ? (string)$serialNumber : null;
    }

    /**
     * Check if the terminal is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool)$this->get(self::ACTIVE_KEY);
    }

    /**
     * Get the terminal group ID
     *
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        $groupId = $this->get(self::GROUP_ID_KEY);
        return $groupId !== null ? (int)$groupId : null;
    }

    /**
     * Get the terminal country code
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        $country = $this->get(self::COUNTRY_KEY);
        return $country !== null ? (string)$country : null;
    }
}
