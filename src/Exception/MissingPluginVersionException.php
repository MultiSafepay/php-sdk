<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */
namespace MultiSafepay\Exception;

use InvalidArgumentException;
use Throwable;

class MissingPluginVersionException extends InvalidArgumentException
{
    /**
     * MissingPluginVersionException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'Plugin version is missing', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
