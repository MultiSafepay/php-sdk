<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\TaxTable;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate\SplitPayment;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Percentage;
use PHPUnit\Framework\TestCase;

/**
 * Class SplitPaymentTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class SplitPaymentTest extends TestCase
{
    /**
     * Test setting fixed amount works
     */
    public function testAddingFixAmount()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addFixed(new Money(10));
        $this->assertEquals(1000, $splitPayment->getFixed()->getAmountInCents());
    }

    /**
     * Test setting a percentage works
     */
    public function testAddPercentage()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addPercentage(new Percentage(10));
        $this->assertEquals(10, $splitPayment->getPercentage()->getValue());
    }

    /**
     * Test setting both a percentage and a fixed amount fails validation
     */
    public function testSettingPercentageAndFixedAmountFailsValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $splitPayment = new SplitPayment();
        $splitPayment->addFixed(new Money(10));
        $splitPayment->addPercentage(new Percentage(10));

        $splitPayment->validate();
    }

    /**
     * Test setting a merchant works
     */
    public function testAddMerchant()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addMerchant('123123');
        $this->assertEquals('123123', $splitPayment->getMerchant());
    }

    /**
     * Test setting a description works
     */
    public function testSettingsDescriptionWorks()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addDescription('application fee');
        $this->assertEquals('application fee', $splitPayment->getDescription());
    }

    /**
     * Test get data for fixed amount
     */
    public function testGetDataForFixedAmount()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addFixed(new Money(10));
        $splitPayment->addDescription('application fee');
        $splitPayment->addMerchant('123123');
        $this->assertEquals([
            'fixed' => 10,
            'description' => 'application fee',
            'merchant' => '123123'
        ], $splitPayment->getData());
    }

    /**
     * Test get data for percentage
     */
    public function testGetDataForPercentage()
    {
        $splitPayment = new SplitPayment();
        $splitPayment->addPercentage(new Percentage(10));
        $splitPayment->addDescription('application fee');
        $splitPayment->addMerchant('123123');
        $this->assertEquals([
            'percentage' => 10,
            'description' => 'application fee',
            'merchant' => '123123'
        ], $splitPayment->getData());
    }

    /**
     * Test fails when no percentage and no fixed amount is set
     */
    public function testItFailsWhenNoPercentageAndNoFixedAmountIsSet()
    {
        $this->expectException(InvalidArgumentException::class);
        $splitPayment = new SplitPayment();
        $splitPayment->addDescription('application fee');
        $splitPayment->addMerchant('123123');
        $splitPayment->validate();
    }

}
