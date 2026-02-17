<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Terminals;

use MultiSafepay\Api\Pager\Pager;
use MultiSafepay\Api\Terminals\TerminalListing;
use PHPUnit\Framework\TestCase;

class TerminalListingTest extends TestCase
{
    /**
     * Check that the listing wraps terminals data and pager.
     */
    public function testTerminalListingWrapsDataAndPager()
    {
        $listing = new TerminalListing(
            [
                ['id' => 'TML-0001', 'provider' => 'SMARTPOS', 'name' => 'Front desk'],
                ['id' => 'TML-0002', 'provider' => 'SMARTPOS', 'name' => 'Bar'],
            ],
            new Pager(['limit' => 50])
        );

        $terminals = $listing->getTerminals();
        $this->assertCount(2, $terminals);
        $this->assertEquals('TML-0001', $terminals[0]->getData()['id']);
        $this->assertEquals('Front desk', $terminals[0]->getData()['name']);
        $this->assertEquals('SMARTPOS', $terminals[0]->getData()['provider']);

        $this->assertNotNull($listing->getPager());
        $this->assertEquals(50, $listing->getPager()->getLimit());
    }
}
