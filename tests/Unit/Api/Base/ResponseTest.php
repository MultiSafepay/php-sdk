<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Base;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\ApiUnavailableException;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Base\Response::getResponseData
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testWithJsonAndResponseData()
    {
        $json = json_encode(['success' => 1, 'data' => ['foo' => 'bar']]);
        $response = Response::withJson($json, ['http_response_code' => 200]);
        $data = $response->getResponseData();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('foo', $data);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testWithUnknownDataThrowsApiException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $json = json_encode(['foo' => 'bar']);
        Response::withJson($json, ['http_response_code' => 200]);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testWithNoSuccessButUnknownDataThrowsApiException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $json = json_encode(['success' => 0, 'data' => ['foo' => 'bar']]);
        Response::withJson($json, ['http_response_code' => 200]);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testWithNoSuccessThrowsApiException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('bar');
        $json = json_encode(['success' => 0, 'error_code' => 42, 'error_info' => 'bar']);
        Response::withJson($json, ['http_response_code' => 200]);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testWithJsonThrowsApiUnavailableExceptionOnInvalidHttpResponseCode()
    {
        $this->expectException(ApiUnavailableException::class);
        $json = json_encode(['data' => ['foo' => 'bar'], 'success' => false]);
        Response::withJson($json, ['http_response_code' => 503]);

        $this->expectException(ApiUnavailableException::class);
        Response::withJson($json, ['http_response_code' => 501]);
    }

    /**
     * @covers \MultiSafepay\Api\Base\Response::withJson
     *
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     */
    public function testGetRawDataReturnsRawJson()
    {
        $json = json_encode(['data' => ['foo' => 'bar'], 'success' => true]);
        $response = Response::withJson($json, ['http_response_code' => 200]);
        $this->assertEquals($json, $response->getRawData());
    }
}
