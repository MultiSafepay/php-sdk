<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Functional;

use MultiSafepay\Client\Client;
use MultiSafepay\Sdk;
use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;

/**
 * Class TestCase
 * @package MultiSafepay\Tests\Functional
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Setup resources for all tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        Version::getInstance()->addPluginVersion('functional-test');
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        require_once __DIR__ . '/../bootstrap.php';

        $apiKey = getenv('API_KEY');
        $this->assertNotEmpty($apiKey);

        return new Client(getenv('API_KEY'), false);
    }

    /**
     * @return Sdk
     */
    protected function getApi(): Sdk
    {
        require_once __DIR__ . '/../bootstrap.php';

        $apiKey = getenv('API_KEY');
        $this->assertNotEmpty($apiKey);

        return new Sdk($apiKey, false);
    }
}
