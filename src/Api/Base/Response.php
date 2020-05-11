<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Exception\ApiException;

/**
 * Class Response
 * @package MultiSafepay\Api\Base
 */
class Response
{
    const ERROR_UNKNOWN_DATA = [412, 'Unknown data'];
    const ERROR_INVALID_DATA_TYPE = [412, 'Invalid data type'];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $json
     * @param array $context
     * @return Response
     */
    public static function withJson(string $json, array $context = [])
    {
        $data = json_decode($json, true);
        if (empty($data)) {
            $data = [];
        }

        return new self($data, $context);
    }

    /**
     * Response constructor.
     * @param array $data
     * @param array $context
     */
    public function __construct(array $data, array $context = [])
    {
        if (!isset($data['success']) && !empty($data['data'])) {
            $data['success'] = true;
        }

        if (!isset($data['success'])) {
            $data['success'] = false;
        }

        $this->validate($data, $context);
        $this->data = $data['data'];
    }

    /**
     * @param array $data
     * @param array $context
     * @return bool
     */
    private function validate(array $data, array $context = []): bool
    {
        if ((bool)$data['success'] === true) {
            return true;
        }

        $errorCode = $data['error_code'] ?? self::ERROR_UNKNOWN_DATA[0];
        $errorInfo = $data['error_info'] ?? self::ERROR_UNKNOWN_DATA[1];

        if (!empty($data['data']) && !is_array($data['data'])) {
            list($errorCode, $errorInfo) = self::ERROR_INVALID_DATA_TYPE;
        }

        if (!$data['success']) {
            throw (new ApiException($errorInfo, $errorCode))->addContext($context);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->data;
    }
}
