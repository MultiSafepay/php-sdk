<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional;

use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;
use MultiSafepay\Client;

/**
 * Class TestCase
 * @package MultiSafepay\Tests\Functional
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        Version::getInstance()->addPluginVersion('functional-test');

        require_once __DIR__ . '/../bootstrap.php';

        $apiKey = getenv('API_KEY');
        $this->assertNotEmpty($apiKey);

        return new Client(getenv('API_KEY'), false);
    }
}
