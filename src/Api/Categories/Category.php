<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Categories;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class Category
 * @package MultiSafepay\Api\Categories
 */
class Category
{
    /**
     * @var string
     */
    private $code = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * Transaction constructor.
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->code = (string)$data['code'];
        $this->description = $data['description'];
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param array $data
     * @return bool
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): bool
    {
        if (empty($data['code']) || empty($data['description'])) {
            throw new InvalidDataInitializationException('No code or description');
        }

        return true;
    }
}
