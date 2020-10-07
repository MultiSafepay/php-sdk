<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;
use PHPUnit\Framework\TestCase;

class IdealTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal::getData
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal::addIssuerId
     */
    public function testGetData()
    {
        $ideal = new Ideal();
        $ideal->addIssuerId('ing');
        $data = $ideal->getData();
        $this->assertSame('ing', $data['issuer_id']);
    }
}
