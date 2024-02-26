<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Exception;

use Exception;

/**
 * Class ApiException
 * @package MultiSafepay\Exception
 */
class ApiException extends Exception
{
    /**
     * @var array
     */
    private $context = [];

    /**
     * @param array $context
     * @return ApiException
     */
    public function addContext(array $context = []): ApiException
    {
        $this->context = array_merge($this->context, $context);
        return $this;
    }

    /**
     * @return string
     */
    public function getDetails(): string
    {
        $lines = [];
        $lines[] = ApiException::class . ': ' . $this->getMessage();
        $lines = array_merge($lines, $this->getContextAsArray());
        return implode("\n", $lines);
    }

    /**
     * @return array
     */
    public function getContextAsArray(): array
    {
        $lines = [];
        foreach ($this->context as $contextName => $contextValue) {
            $debugValue = $contextValue;
            if (!is_string($debugValue)) {
                $debugValue = json_encode($contextValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }
            $lines[] = $contextName . ": " . $debugValue;
        }
        return $lines;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getContextValue(string $name)
    {
        return $this->context[$name] ?? null;
    }
}
