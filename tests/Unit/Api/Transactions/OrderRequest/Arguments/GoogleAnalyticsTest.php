<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class DescriptionTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class GoogleAnalyticsTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics::addAccountId
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics::getData
     */
    public function testaddAccountId()
    {
        $googleAnalytics = new GoogleAnalytics();
        $googleAnalytics->addAccountId('test');
        $data = $googleAnalytics->getData();
        $this->assertSame('test', $data['account']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics::getData
     */
    public function testInvalidData()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Account ID can not be empty');
        $googleAnalytics = new GoogleAnalytics();
        $googleAnalytics->getData();
    }
}
