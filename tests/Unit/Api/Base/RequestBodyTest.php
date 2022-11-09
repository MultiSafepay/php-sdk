<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Base;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;

class RequestBodyTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Base\RequestBody::createRequestBodyFromJson
     */
    public function testCreateRequestBodyFromJson()
    {
        $json = json_encode(['foo' => 'bar']);
        $requestBody = RequestBody::createRequestBodyFromJson($json);
        $this->assertSame('bar', $requestBody->get('foo'));
    }

    /**
     * @covers \MultiSafepay\Api\Base\RequestBody::createRequestBodyFromArray
     */
    public function testCreateRequestBodyFromArray()
    {
        $data = ['foo' => 'bar'];
        $requestBody = RequestBody::createRequestBodyFromArray($data);
        $this->assertSame('bar', $requestBody->get('foo'));
    }

    /**
     * @covers \MultiSafepay\Api\Base\RequestBody::getData
     */
    public function testGetData()
    {
        $data = ['foo' => 'bar'];
        Version::getInstance()->addPluginVersion('0.0.1');
        $requestBody = RequestBody::createRequestBodyFromArray($data);
        $requestData = $requestBody->getData();
        $this->assertSame('bar', $requestData['foo']);
        $this->assertNotEmpty($requestData['plugin']);
    }

    /**
     * @covers \MultiSafepay\Api\Base\RequestBody::createRequestBodyFromArray
     */
    public function testExceptionWhenVersionIsMissing()
    {
        $this->expectException(MissingPluginVersionException::class);
        $data = ['foo' => 'bar'];
        Version::getInstance()->addPluginVersion('unknown');
        $requestBody = RequestBody::createRequestBodyFromArray($data);
        $requestBody->getData();
    }
}
