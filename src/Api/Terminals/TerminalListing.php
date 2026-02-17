<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Terminals;

use MultiSafepay\Api\Pager\Pager;

class TerminalListing
{
    /**
     * @var Terminal[]
     */
    private $terminals;

    /**
     * @var Pager|null
     */
    private $pager;

    /**
     * @param array $data
     * @param Pager|null $pager
     */
    public function __construct(array $data, ?Pager $pager = null)
    {
        $terminals = [];
        if (!empty($data)) {
            foreach ($data as $terminalData) {
                $terminals[] = new Terminal((array)$terminalData);
            }
        }
        $this->terminals = $terminals;

        if (isset($pager)) {
            $this->pager = $pager;
        }
    }

    /**
     * @return Terminal[]
     */
    public function getTerminals(): array
    {
        return $this->terminals;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        $terminals = [];
        foreach ($this->terminals as $terminal) {
            $terminals[] = $terminal->getData();
        }

        return $terminals;
    }

    /**
     * @return Pager|null
     */
    public function getPager(): ?Pager
    {
        return $this->pager ?? null;
    }
}
