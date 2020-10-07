<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TaxTableTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable::validate
     */
    public function testValidate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No tax rules given');
        $taxTable = new TaxTable;
        $taxTable->validate();
    }

    public function test()
    {
        $taxRate = new TaxTable\TaxRate();
        $taxRate->addRate(42);

        $taxRule = new TaxTable\TaxRule();
        $taxRule->addTaxRate($taxRate);
        $taxRule->addName('foobar');

        $taxTable = new TaxTable($taxRate);
        $taxTable->addTaxRules([$taxRule]);
        $data = $taxTable->getData();
        $this->assertSame(1, count($data['alternate']));
        $this->assertSame(0.42, $data['default']['rate']);
    }
}
