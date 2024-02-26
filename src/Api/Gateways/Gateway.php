<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class Gateway
 * @package MultiSafepay\Api\Gateways
 * phpcs:disable ObjectCalisthenics.Files.FunctionLength
 */
class Gateway
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * Transaction constructor.
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->id = $data['id'];
        $this->description = $data['description'];
        $this->type = $data['type'] ?? '';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param array $data
     * @return bool
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): bool
    {
        if (empty($data['id']) || empty($data['description'])) {
            throw new InvalidDataInitializationException('No ID or description');
        }

        return true;
    }
}
