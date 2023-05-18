<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Util\Version;

/**
 * Class RequestBody
 * @package MultiSafepay\Api\Base
 */
class RequestBody extends DataObject implements RequestBodyInterface
{
    /**
     * @var bool
     */
    protected $strictMode = false;

    /**
     * @param string $json
     * @return RequestBody
     */
    public static function createRequestBodyFromJson(string $json): RequestBody
    {
        return new RequestBody(json_decode($json, true));
    }

    /**
     * @param array $data
     * @return RequestBody
     */
    public static function createRequestBodyFromArray(array $data): RequestBody
    {
        return new RequestBody($data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->data['plugin']['plugin_version'] = Version::getInstance()->getVersion();
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function useStrictMode(bool $strictMode)
    {
        $this->strictMode = $strictMode;
    }
}
