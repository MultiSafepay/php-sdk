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
}
