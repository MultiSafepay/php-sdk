<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Util\Version;

/**
 * Class CustomInfo
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class CustomInfo
{
    /**
     * @var string
     */
    private $custom1;

    /**
     * @var string
     */
    private $custom2;

    /**
     * @var string
     */
    private $custom3;


    /**
     * @param string $custom1
     * @return CustomInfo
     */
    public function addCustom1(string $custom1): CustomInfo
    {
        $this->custom1 = $custom1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom1(): ?string
    {
        return $this->custom1;
    }


    /**
     * @param string $custom2
     * @return CustomInfo
     */
    public function addCustom2(string $custom2): CustomInfo
    {
        $this->custom2 = $custom2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom2(): ?string
    {
        return $this->custom2;
    }

    /**
     * @param string $custom3
     * @return CustomInfo
     */
    public function addCustom3(string $custom3): CustomInfo
    {
        $this->custom3 = $custom3;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getCustom3(): ?string
    {
        return $this->custom3;
    }
    

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'custom_1' => $this->getCustom1(),
            'custom_2' => $this->getCustom2(),
            'custom_3' => $this->getCustom3(),
        ];
    }
}
