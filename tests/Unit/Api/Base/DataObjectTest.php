<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Base;

use MultiSafepay\Api\Base\DataObject;
use PHPUnit\Framework\TestCase;

class DataObjectTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Base\DataObject::addData
     */
    public function testAddData()
    {
        $dataObject = new DataObject(['foo' => 'bar']);
        $dataObject->addData(['foo' => 'bar']);
        $foo = $dataObject->get('foo');
        $this->assertSame('bar', $foo);
    }

    /**
     * @covers \MultiSafepay\Api\Base\DataObject::get
     */
    public function testGet()
    {
        $dataObject = new DataObject(['foo' => 'bar']);
        $this->assertSame('bar', $dataObject->get('foo'));
    }

    /**
     * @covers \MultiSafepay\Api\Base\DataObject::getData
     */
    public function testGetData()
    {
        $dataObject = new DataObject(['foo' => 'bar']);
        $data = $dataObject->getData();
        $this->assertSame('bar', $data['foo']);
    }

    /**
     * @covers \MultiSafepay\Api\Base\DataObject::removeNull
     */
    public function testRemoveNull()
    {
        $dataObject = new DataObject([]);
        $data = ['foo' => null];
        $newData = $dataObject->removeNull($data);
        $this->assertArrayNotHasKey('foo', $newData);
    }

    /**
     * @covers \MultiSafepay\Api\Base\DataObject::removeNullRecursive
     */
    public function testRemoveNullRecursive()
    {
        $dataObject = new DataObject([]);
        $data = ['foo' => ['bar' => null]];
        $newData = $dataObject->removeNullRecursive($data);
        $foo = $newData['foo'];
        $this->assertArrayNotHasKey('bar', $foo);
    }
}
