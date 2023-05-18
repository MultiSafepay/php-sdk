<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\RequestBodyInterface;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Transactions
 */
class UpdateRequest extends RequestBody implements RequestBodyInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive(
            array_merge(
                [
                    'id' => $this->id ? $this->id : null,
                    'status' => $this->status ? $this->status : null,
                ],
                $this->data
            )
        );
    }

    /**
     * @param string $id
     * @return UpdateRequest
     */
    public function addId(string $id): UpdateRequest
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $status
     * @return UpdateRequest
     */
    public function addStatus(string $status): UpdateRequest
    {
        $this->status = $status;
        return $this;
    }
}
