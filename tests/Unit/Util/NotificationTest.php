<?php declare(strict_types=1);
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Util;

use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Util\Notification;
use PHPUnit\Framework\TestCase;

/**
 * Class NotificationTest
 * @package MultiSafepay\Tests\Unit\Util
 *
 */
class NotificationTest extends TestCase
{

    /**
     * @var string
     */
    private $apiKey = 'your-MultiSafepay-API-key';
    /**
     * @var string
     * phpcs:disable Generic.Files.LineLength.TooLong
     */
    private $auth = 'MTYxNjYwMTg1MTo2ZTRhZTg2MzhhYTJmOWUxNTkyYjA3NDM3NmY2ODE2MTk2NTQ2MzMxYTliOWU5NDlkMWFiNWVmNmE5MzFjYjA5ZWQ4M2FkMTJmODUzZjI5ZGYyMjMxZThmODgzZTJiMThhYWVmN2NiYWZmMTA5NGU5ZmQ5ZmNlMWRkMzYyZjJhNA==';
    /**
     * @var string
     * phpcs:disable Generic.Files.LineLength.TooLong
     */
    private $json = '{"amount":24293,"amount_refunded":0,"checkout_options":{"alternate":[{"name":"0","rules":[{"country":"","rate":"0.00"}],"standalone":""}],"default":[]},"costs":[{"amount":7.04,"description":"2.9 % For Visa CreditCards Transactions (min 0.6)","transaction_id":"2583849","type":"SYSTEM"}],"created":"2021-03-24T16:26:31","currency":"GBP","custom_info":{"custom_1":null,"custom_2":null,"custom_3":null},"customer":{"address1":"Kraanspoor","address2":null,"city":"Amsterdam","country":"NL","country_name":null,"email":"john.doe@example.com","first_name":"John","house_number":"39C","last_name":"Doe","locale":"nl_NL","phone1":"0612345678","phone2":"","state":null,"zip_code":"1033SC"},"description":"Payment for order: 182","fastcheckout":"NO","financial_status":"completed","items":"<table border=\"0\" cellpadding=\"5\" width=\"100%\">\n<tr>\n<th width=\"10%\"><font size=\"2\" face=\"Verdana\">Quantity </font></th>\n<th align=\"left\"></th>\n<th align=\"left\"><font size=\"2\" face=\"Verdana\">Details </font></th>\n<th width=\"19%\" align=\"right\"><font size=\"2\" face=\"Verdana\">Price </font></th>\n</tr>\n<tr>\n<td align=\"center\"><font size=\"2\" face=\"Verdana\">1</font></td>\n<td width=\"6%\"></td>\n<td width=\"65%\"><font size=\"2\" face=\"Verdana\">Ergonomic Paper Table</font></td>\n<td align=\"right\">&pound;<font size=\"2\" face=\"Verdana\">242.93</font>\n</td>\n</tr>\n</table>","modified":"2021-03-24T16:26:38","order_id":"182","payment_details":{"account_holder_name":"MultiSafepay","account_id":null,"card_expiry_date":"2404","external_transaction_id":"234453696","last4":"1111","recurring_flow":null,"recurring_id":"99814704667013722040","recurring_model":null,"type":"VISA"},"payment_methods":[{"account_holder_name":"MultiSafepay","amount":24293,"card_expiry_date":2404,"currency":"GBP","description":"Payment for order: 182","external_transaction_id":"234453696","last4":1111,"payment_description":"Visa CreditCards","status":"completed","type":"VISA"}],"reason":"","reason_code":"","related_transactions":null,"shopping_cart":{"items":[{"cashback":"","currency":"GBP","description":"","image":"","merchant_item_id":"68","name":"Ergonomic Paper Table","options":[],"product_url":"","quantity":"1","tax_table_selector":"0","unit_price":"242.9300000000","weight":{"unit":null,"value":null}}]},"status":"completed","transaction_id":4680345,"var1":null,"var2":"182","var3":null}';

    /**
     * Check if the verify function work without validation time in check
     */
    public function testCheckAuthWithNoTimestampCheck()
    {
        $this->assertTrue(Notification::verifyNotification($this->json, $this->auth, $this->apiKey, 0));
    }

    /**
     * Test the check while the validation time has been exceeded.
     */
    public function testCheckAuthWithFailingTimestampCheck()
    {
        $this->assertFalse(Notification::verifyNotification($this->json, $this->auth, $this->apiKey, 1));
    }

    /**
     * Check if the verify will fail due to having a invalid key
     */
    public function testVerifyWithInvalidApiKey()
    {
        $this->assertFalse(Notification::verifyNotification($this->json, $this->auth, 'a-fake-API-key', 0));
    }

    /**
     * Check if the verify will fail due to having invalid arguments
     */
    public function testVerifyWithInvalidJSONArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        Notification::verifyNotification(1, $this->auth, $this->apiKey, 0);
    }

    /**
     * Check if the verify will fail due to having invalid arguments
     */
    public function testVerifyWithInvalidValidationTimeArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        Notification::verifyNotification($this->json, $this->auth, $this->apiKey, -1);
    }

    /**
     * Check if the verify will work when using the transaction response instead of the JSON string
     */
    public function testVerifyWithTransactionResponseClass()
    {
        $class = new TransactionResponse(json_decode($this->json, true), $this->json);
        $this->assertTrue(Notification::verifyNotification($class, $this->auth, $this->apiKey, 0));
    }

    /**
     * Check if the the signature is being validated even when contains empty spaces at the front or back
     */
    public function testVerifyWithEmptySpacesInApiKey()
    {
        $class = new TransactionResponse(json_decode($this->json, true), $this->json);
        $this->assertTrue(Notification::verifyNotification($class, $this->auth, ' ' . $this->apiKey, 0));
    }
}
