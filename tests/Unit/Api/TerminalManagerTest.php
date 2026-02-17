<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api;

use MultiSafepay\Api\TerminalManager;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;

class TerminalManagerTest extends TestCase
{
    /**
     * Check that fetching terminals by group returns a listing.
     */
    public function testGetTerminalsByGroupReturnsListing()
    {
        $client = MockClient::getInstance();
        $client->mockResponseFromFixtureFile('terminals-by-group');

        $manager = new TerminalManager($client);
        $listing = $manager->getTerminalsByGroup('group-123', ['page' => 1, 'limit' => 50]);

        $this->assertCount(2, $listing->getTerminals());
        $this->assertEquals('000013Z1312312', $listing->getTerminals()[0]->getData()['id']);
        $this->assertNotNull($listing->getPager());
    }

    /**
     * Check that fetching terminals returns a listing.
     */
    public function testGetTerminalsReturnsListing()
    {
        $client = MockClient::getInstance();
        $client->mockResponseFromFixtureFile('terminals');

        $manager = new TerminalManager($client);
        $listing = $manager->getTerminals(['page' => 1, 'limit' => 50]);

        $this->assertCount(1, $listing->getTerminals());
        $this->assertEquals('000013Z1312312', $listing->getTerminals()[0]->getData()['id']);
        $this->assertNotNull($listing->getPager());
    }
}
