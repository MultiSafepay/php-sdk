<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::getData
     */
    public function testGetData()
    {
        $meta = new Meta();
        $meta->addBankAccount(new BankAccount('test'));
        $meta->addBirthday(new Date('1970-01-01'));
        $meta->addEmailAddress(new EmailAddress('info@example.org'));
        $meta->addGender(new Gender('male'));
        $meta->addPhone(new PhoneNumber('0123456789'));
        $meta->addData(['foo' => 'bar']);
        $data = $meta->getData();
        $this->assertSame('test', $data['bankaccount']);
        $this->assertSame('1970-01-01', $data['birthday']);
        $this->assertSame('info@example.org', $data['email']);
        $this->assertSame('male', $data['gender']);
        $this->assertSame('0123456789', $data['phone']);
        $this->assertSame('bar', $data['foo']);
    }

    /**
     * Test if value object variables that belong to the Meta class can be set using their to AsString functions
     *
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::addBankAccountAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::addBirthdayAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::addEmailAddressAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::addGenderAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta::addPhoneAsString
     */
    public function testSettingValueObjectsUsingAsStringMethods()
    {
        $meta = new Meta();
        $meta->addBankAccountAsString('test');
        $meta->addBirthdayAsString('1970-01-01');
        $meta->addEmailAddressAsString('info@example.org');
        $meta->addGenderAsString('male');
        $meta->addPhoneAsString('0123456789');

        $data = $meta->getData();
        $this->assertSame('test', $data['bankaccount']);
        $this->assertSame('1970-01-01', $data['birthday']);
        $this->assertSame('info@example.org', $data['email']);
        $this->assertSame('male', $data['gender']);
        $this->assertSame('0123456789', $data['phone']);
    }
}
