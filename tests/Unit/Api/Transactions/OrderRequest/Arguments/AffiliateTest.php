<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;

class AffiliateTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate::getData
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate::addSplitPayments
     */
    public function testGetData()
    {
        $splitPayment = new Affiliate\SplitPayment();
        $splitPayment->addMerchant('merchant');
        $splitPayment->addFixed(new Money(10));

        $affiliate = new Affiliate();
        $affiliate->addSplitPayments([
            $splitPayment
        ]);

        $data = $affiliate->getData();
        $this->assertSame(1, count($data['split_payments']));
        $this->assertSame([
            'merchant' => 'merchant',
            'fixed' => 10,
            'description' => null,
        ], $data['split_payments'][0]);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate::getData
     */
    public function testUsingConstructors()
    {
        $splitPayment = new Affiliate\SplitPayment(
            'merchant',
            new Money(10)
        );

        $affiliate = new Affiliate([$splitPayment]);

        $data = $affiliate->getData();
        $this->assertSame(1, count($data['split_payments']));
        $this->assertSame([
            'merchant' => 'merchant',
            'fixed' => 10,
            'description' => null,
        ], $data['split_payments'][0]);
    }
}
