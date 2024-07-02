<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Api\Pager\Pager;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\ApiUnavailableException;

/**
 * Class Response
 * @package MultiSafepay\Api\Base
 */
class Response
{
    public const ERROR_UNKNOWN_DATA = [412, 'Unknown data'];
    public const ERROR_INVALID_DATA_TYPE = [412, 'Invalid data type'];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $raw;

    /**
     * @var Pager
     */
    private $pager;

    /**
     * @param string $json
     * @param array $context
     * @return Response
     * @throws ApiException|ApiUnavailableException
     */
    public static function withJson(string $json, array $context = []): Response
    {
        $data = json_decode($json, true);
        if (empty($data)) {
            $data = [];
        }

        return new self($data, $context, $json);
    }

    /**
     * Response constructor.
     * @param array $data
     * @param array $context
     * @param string $raw
     * @throws ApiException|ApiUnavailableException
     */
    public function __construct(array $data, array $context = [], string $raw = '')
    {
        if (!isset($data['success']) && !empty($data['data'])) {
            $data['success'] = true;
        }

        if (!isset($data['success'])) {
            $data['success'] = false;
        }

        $this->raw = $raw;
        $this->validate($data, $context);
        $this->data = $data['data'];

        if (isset($data['pager'])) {
            $this->pager = new Pager($data['pager']);
        }
    }

    /**
     * Validate the response
     *
     * @param array $data
     * @param array $context
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    private function validate(array $data, array $context = []): void
    {
        if ((bool)$data['success'] === true) {
            return;
        }

        $errorCode = $data['error_code'] ?? self::ERROR_UNKNOWN_DATA[0];
        $errorInfo = $data['error_info'] ?? self::ERROR_UNKNOWN_DATA[1];

        if (!empty($data['data']) && !is_array($data['data'])) {
            [$errorCode, $errorInfo] = self::ERROR_INVALID_DATA_TYPE;
        }

        if (in_array($context['http_response_code'], [501, 503])) {
            throw (new ApiUnavailableException(
                'The MultiSafepay API could not be reached',
                $context['http_response_code']
            ));
        }

        if (!$data['success']) {
            $context['raw_response_body'] = $this->raw;
            throw (new ApiException($errorInfo, $errorCode))->addContext($context);
        }
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getRawData(): string
    {
        return $this->raw;
    }

    /**
     * @return Pager
     */
    public function getPager(): Pager
    {
        return $this->pager;
    }
}
