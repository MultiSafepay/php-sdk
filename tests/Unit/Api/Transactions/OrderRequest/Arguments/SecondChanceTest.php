<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
use PHPUnit\Framework\TestCase;

class SecondChanceTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance::addSendEmail
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance::getData
     */
    public function testAddSendEmail()
    {
        $secondChance = new SecondChance();
        $secondChance->addSendEmail(true);
        $data = $secondChance->getData();
        $this->assertSame(true, $data['send_email']);

        $secondChance->addSendEmail(false);
        $data = $secondChance->getData();
        $this->assertSame(false, $data['send_email']);
    }
}
