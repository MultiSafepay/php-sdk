<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Base;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Exception\ApiException;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Base\Response::getResponseData
     * @covers \MultiSafepay\Api\Base\Response::withJson
     */
    public function testWithJsonAndResponseData()
    {
        $json = json_encode(['success' => 1, 'data' => ['foo' => 'bar']]);
        $response = Response::withJson($json);
        $data = $response->getResponseData();
        $this->assertArrayHasKey('foo', $data);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     */
    public function testWithUnknownData()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $json = json_encode(['foo' => 'bar']);
        Response::withJson($json);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     */
    public function testWithNoSuccessButUnknownData()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $json = json_encode(['success' => 0, 'data' => ['foo' => 'bar']]);
        Response::withJson($json);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     */
    public function testWithNoSuccess()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('bar');
        $json = json_encode(['success' => 0, 'error_code' => 42, 'error_info' => 'bar']);
        Response::withJson($json);
    }
}
