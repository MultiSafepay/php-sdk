<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Terminal;
use PHPUnit\Framework\TestCase;

class TerminalTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Terminal::getData
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Terminal::addTerminalId
     */
    public function testGetData()
    {
        $terminal = new Terminal();
        $terminal->addTerminalId('terminal-id');
        $data = $terminal->getData();
        $this->assertSame('terminal-id', $data['terminal_id']);
    }
}
