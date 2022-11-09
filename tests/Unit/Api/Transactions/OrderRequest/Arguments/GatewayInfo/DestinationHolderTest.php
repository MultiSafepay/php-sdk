<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder;
use PHPUnit\Framework\TestCase;

class DestinationHolderTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::getData
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::addName
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::addCity
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::addCountry
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::addIban
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\DestinationHolder::addSwift
     */
    public function testGetData()
    {
        $destinationHolder = new DestinationHolder();
        $destinationHolder->addName('John Doe');
        $destinationHolder->addCity('Amsterdam');
        $destinationHolder->addCountry('NL');
        $destinationHolder->addIban('iban');
        $destinationHolder->addSwift('swift');
        $data = $destinationHolder->getData();
        $this->assertSame('John Doe', $data['destination_holder_name']);
        $this->assertSame('Amsterdam', $data['destination_holder_city']);
        $this->assertSame('NL', $data['destination_holder_country']);
        $this->assertSame('iban', $data['destination_holder_iban']);
        $this->assertSame('swift', $data['destination_holder_swift']);
    }
}
