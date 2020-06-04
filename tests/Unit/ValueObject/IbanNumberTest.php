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
     * Test whether a number is correct
     * @dataProvider getFakeIbanNumbers
     */
    public function testWhetherIbanNumberIsValid(string $exampleIban)
    {
        $ibanNumber = new IbanNumber($exampleIban);
        $this->assertEquals($exampleIban, $ibanNumber->get());
    }

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
    public function getFakeIbanNumbers(): array
    {
        $faker = Factory::create();
        return [
            ['AE020200000030124176201'],
            ['AE320030010274073001001'],
            ['BE57800228915735'],
            ['BE59 65283724 9926'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidIbanNumbers(): array
    {
        return [
            ['5065z03uh5z89y4o9ry7fs'],
            ['md5065Sz03uh5z89y4o9ry7f00000s'],
        ];
    }
}
