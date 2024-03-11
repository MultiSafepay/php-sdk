<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Util;

use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Exception\InvalidArgumentException;

class Notification
{
    /**
     * @param TransactionResponse|string $request
     * @param string $auth
     * @param string $apiKey
     * @param int $validationTimeInSeconds
     * phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function verifyNotification(
        $request,
        string $auth,
        string $apiKey,
        int $validationTimeInSeconds = 600
    ): bool {
        if ($request instanceof TransactionResponse) {
            $request = $request->getRawData();
        }

        if (!is_string($request)) {
            throw new InvalidArgumentException(
                'Request can only be a string or \MultiSafepay\Api\Transactions\TransactionResponse with raw data'
            );
        }

        if ($validationTimeInSeconds < 0) {
            throw new InvalidArgumentException('Argument validationTimeInSeconds must be equal or greater than 0');
        }

        $authHeaderDecoded = base64_decode($auth);
        [$timestamp, $sha512hexPayload] = explode(':', $authHeaderDecoded);

        if ($validationTimeInSeconds > 0 && (int)$timestamp + $validationTimeInSeconds < time()) {
            return false;
        }

        $payload = $timestamp . ':' . $request;
        $hash = hash_hmac('sha512', $payload, trim($apiKey));

        return $hash === $sha512hexPayload;
    }
}
