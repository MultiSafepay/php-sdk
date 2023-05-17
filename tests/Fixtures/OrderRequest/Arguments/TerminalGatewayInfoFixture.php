<?php declare(strict_types=1);
/**
 * Copyright © 2023 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Terminal;

/**
 * Trait TerminalGatewayInfoFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait TerminalGatewayInfoFixture
{
    /**
     * @return Terminal
     */
    public function createTerminalGatewayInfoFixture(): Terminal
    {
        return (new Terminal())
            ->addTerminalId('terminal-id');
    }
}
