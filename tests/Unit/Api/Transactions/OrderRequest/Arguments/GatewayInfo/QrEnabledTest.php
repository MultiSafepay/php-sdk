<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\QrEnabled;
use PHPUnit\Framework\TestCase;

class QrEnabledTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\QrEnabled::getData
     */
    public function testGetData()
    {
        $qrEnabled = new QrEnabled();
        $qrEnabled->addQrEnabled(true);
        $data = $qrEnabled->getData();
        $this->assertSame(1, $data['qr_enabled']);

        $qrEnabled->addQrEnabled(false);
        $data = $qrEnabled->getData();
        $this->assertSame(0, $data['qr_enabled']);
    }
}
