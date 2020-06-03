<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class DescriptionTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class DescriptionTest extends TestCase
{
    /**
     * Test case to guarantee that Description is set properly
     */
    public function testAddDescription()
    {
        $description = new Description();
        $description->addDescription('foobar');
        $this->assertEquals('foobar', $description->getData());
    }

    /**
     * Test case to guarantee that Description is set properly
     */
    public function testAddDescriptionWithTooLongText()
    {
        $this->expectException(InvalidArgumentException::class);
        $description = new Description();
        $randomString = $this->getRandomString(201);
        $description->addDescription($randomString);
        $description->getData();
    }

    /**
     * @param int $length
     * @return string
     */
    public function getRandomString(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }
}
