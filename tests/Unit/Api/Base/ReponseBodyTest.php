<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Base;

use MultiSafepay\Api\Base\ResponseBody;
use PHPUnit\Framework\TestCase;

class ReponseBodyTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Base\ResponseBody::get
     */
    public function testGet()
    {
        $reponseBody = new ResponseBody(['foo' => 'bar']);
        $this->assertSame('bar', $reponseBody->get('foo'));
    }
}
