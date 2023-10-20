<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomInfo;
use PHPUnit\Framework\TestCase;

/**
 * Class DescriptionTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class CustomInfoTest extends TestCase
{
    /**
     * Test case to guarantee that Custominfo properties is set properly
     */
    public function testAddCustomInfo()
    {
        $customInfo = $this->getCustomInfo();
        $this->assertEquals('Multi', $customInfo->getCustom1());
        $this->assertEquals('Safe', $customInfo->getCustom2());
        $this->assertEquals('pay', $customInfo->getCustom3());
    }

     /**
     * Test case to guarantee that Custominfo getData return data array properly
     */
    public function testWorkingCustomInfo()
    {
        $customInfo = $this->getCustomInfo();
        $customInfoData = $customInfo->getData();
        $this->assertEquals('Multi', $customInfoData['custom_1']);
        $this->assertEquals('Safe', $customInfoData['custom_2']);
        $this->assertEquals('pay', $customInfoData['custom_3']);
    }

    /**
     * @return CustomInfo
     */
    private function getCustomInfo(): CustomInfo
    {
        $customInfo = new CustomInfo();
        $customInfo->addCustom1('Multi');
        $customInfo->addCustom2('Safe');
        $customInfo->addCustom3('pay');
        return $customInfo;
    }
}
