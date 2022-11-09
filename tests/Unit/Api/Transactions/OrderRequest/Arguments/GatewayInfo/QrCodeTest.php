<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\QrCode;
use PHPUnit\Framework\TestCase;

/**
 * Class QrCodeTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class QrCodeTest extends TestCase
{
    /**
     * Test to see if adding stuff results in the proper output array
     */
    public function testGetData()
    {
        $qrCode = new QrCode();
        $qrCode->addAllowChangeAmount(true);
        $qrCode->addMinAmount(42);
        $data = $qrCode->getData();
        $this->assertEquals(true, $data['allow_change_amount']);
        $this->assertEquals(42, $data['min_amount']);
        $this->assertEquals(null, $data['max_amount']);

        $qrCode = new QrCode();
        $qrCode->addQrSize(400);
        $qrCode->addAllowMultiple(true);
        $qrCode->addMaxAmount(42);
        $data = $qrCode->getData();
        $this->assertEquals(400, $data['qr_size']);
        $this->assertEquals(true, $data['allow_multiple']);
        $this->assertEquals(null, $data['min_amount']);
        $this->assertEquals(42, $data['max_amount']);
    }
}
