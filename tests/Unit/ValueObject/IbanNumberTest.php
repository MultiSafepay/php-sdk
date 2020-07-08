<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject;

use Faker\Factory;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\IbanNumber;
use PHPUnit\Framework\TestCase;

/**
 * Class IpAddressTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class IbanNumberTest extends TestCase
{
    /**
     * Test whether a number is incorrect
     * @dataProvider getInvalidIbanNumbers
     */
    public function testWhetherIbanNumberIsInvalid(string $exampleIban)
    {
        $this->expectException(InvalidArgumentException::class);
        new IbanNumber($exampleIban);
    }

    /**
     * @return array
     */
    public function getInvalidIbanNumbers(): array
    {
        return [
            ['5065z03uh5z89y4o9ry7fs'],
            ['m25065Sz03uh5z89y4o9ry7f00000s'],
        ];
    }
}
