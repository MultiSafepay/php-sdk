<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class Terminal
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Terminal implements GatewayInfoInterface
{
    /**
     * @var string
     */
    protected $terminalId;

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'terminal_id' => $this->terminalId,
        ];
    }

    /**
     * @param string $terminalId
     * @return Terminal
     */
    public function addTerminalId(string $terminalId): Terminal
    {
        $this->terminalId = $terminalId;
        return $this;
    }
}
