<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

/**
 * Class DataObject
 * @package MultiSafepay\Api\Base
 */
class DataObject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * RequestBody constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->addData($data);
    }

    /**
     * @param array $data
     * @param bool $recursive
     * @return DataObject
     */
    public function addData(array $data, bool $recursive = false): DataObject
    {
        if ($recursive) {
            $this->data = array_merge_recursive($this->data, $data);
            return $this;
        }

        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $data = $this->getData();
        return $data[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function removeNull(array $data): array
    {
        $data = array_filter(
            $data,
            function ($value) {
                return !is_null($value);
            }
        );

        return $data;
    }

    /**
     * @param $input
     * @return array
     */
    public function removeNullRecursive($input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->removeNullRecursive($value);
            }
        }

        return $this->removeNull($input);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    private function set(string $name, $value)
    {
        $this->data['name'] = $value;
    }
}
