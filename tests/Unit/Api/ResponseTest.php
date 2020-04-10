<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Exception\ApiException;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 * @package MultiSafepay\Tests\Unit\Api
 */
class ResponseTest extends TestCase
{
    /**
     * Test valid use cases
     *
     * @return void
     */
    public function testGetResponseData()
    {
        $response = new Response(['data' => ['foo' => 'bar'], 'success' => 1]);
        $this->assertContains('bar', $response->getResponseData());

        $response = new Response(['data' => ['foo' => 'bar']]);
        $this->assertContains('bar', $response->getResponseData());

        $response = new Response(['data' => [], 'success' => 1]);
        $this->assertEmpty($response->getResponseData());
    }

    /**
     * Test invalid use cases
     *
     * @return void
     */
    public function testGetResponseDataWithErrors()
    {
        $this->expectException(ApiException::class);

        $this->expectExceptionCode(42);
        $this->expectExceptionMessage('Sample error message');
        new Response([
            'data' => ['foo' => 'bar'],
            'success' => 0,
            'error_code' => 42,
            'error_info' => 'Sample error message'
        ]);

        $this->expectExceptionCode(42);
        $this->expectExceptionMessage('Sample error message');
        new Response([
            'data' => ['foo' => 'bar'],
            'success' => 0,
            'error_code' => 42,
            'error_info' => 'Sample error message'
        ]);

        $this->expectExceptionCode(Response::ERROR_UNKNOWN_DATA[0]);
        $this->expectExceptionMessage(Response::ERROR_UNKNOWN_DATA[1]);
        new Response([]);

        $this->expectExceptionCode(Response::ERROR_INVALID_DATA_TYPE[0]);
        $this->expectExceptionMessage(Response::ERROR_INVALID_DATA_TYPE[1]);
        new Response(['data' => []]);

        $this->expectExceptionCode(Response::ERROR_INVALID_DATA_TYPE[0]);
        $this->expectExceptionMessage(Response::ERROR_INVALID_DATA_TYPE[1]);
        new Response(['data' => 'foobar', 'success' => 1]);

        $this->expectExceptionCode(Response::ERROR_INVALID_DATA_TYPE[0]);
        $this->expectExceptionMessage(Response::ERROR_INVALID_DATA_TYPE[1]);
        new Response(['success' => 0]);
    }
}
