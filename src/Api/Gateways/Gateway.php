<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

use MultiSafepay\Exception\InvalidDataInitializationException;

class Gateway
{
    /**
     * @var array
     */
    private $data;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->data['id'];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->data['description'];
    }

    /**
     * @param array $data
     * @return bool
     */
    private function validate(array $data): bool
    {
        if (empty($data['id']) || empty($data['description'])) {
            throw new InvalidDataInitializationException('No ID or description');
        }

        return true;
    }
}
