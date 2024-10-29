# Examples usage of the SDK

### Getting a list of gateways
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\Gateways\Gateway[] $gateways **/
$gateways = $multiSafepaySdk->getGatewayManager()->getGateways();
```

### Getting a specific gateway
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\Gateways\Gateway $gateway **/
$gateway = $multiSafepaySdk->getGatewayManager()->getByCode('VISA');
```

### Getting a list of payment methods and their properties
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\PaymentMethods\PaymentMethod[] $paymentMethods **/
$paymentMethods = $multiSafepaySdk->getPaymentMethodManager()->getPaymentMethods();
```

### Getting a specific payment method properties by gateway code 
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\PaymentMethods\PaymentMethod $paymentMethod **/
$paymentMethod = $multiSafepaySdk->getPaymentMethodManager()->getByGatewayCode('VISA');
```

### Getting a list of categories
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\Categories\Category[] $categories **/
$categories = $multiSafepaySdk->getCategoryManager()->getCategories();
```

### Getting a list of iDEAL issuers
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\Issuers\Issuer[] $issuers **/
$issuers = $multiSafepaySdk->getIssuerManager()->getIssuersByGatewayCode('IDEAL');
```

### Getting order details by Order ID
```php
$yourApiKey = 'your-api-key';
$orderId = 'order-id';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\Transactions\TransactionResponse $apiToken **/
$transaction = $multiSafepaySdk->getTransactionManager()->get($orderId);
```

### Getting an API Token
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
/** @var \MultiSafepay\Api\ApiTokens\ApiToken $apiToken **/
$apiToken = $multiSafepaySdk->getApiTokenManager()->get();
```

### Create an order without shopping cart
```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = (string) time();
$description = 'Order #' . $orderId;
$amount = new Amount(2000); // Amount must be in cents
$currency = new Currency('EUR');

$address = (new Address())
    ->addStreetName('Kraanspoor')
    ->addStreetNameAdditional('(blue door)')
    ->addHouseNumber('39')
    ->addZipCode('1033SC')
    ->addCity('Amsterdam')
    ->addState('Noord Holland')
    ->addCountry(new Country('NL'));

$customer = (new CustomerDetails())
    ->addFirstName('John')
    ->addLastName('Doe')
    ->addAddress($address)
    ->addEmailAddress(new EmailAddress('noreply@example.org'))
    ->addPhoneNumber(new PhoneNumber('0208500500'))
    ->addLocale('nl_NL');

$pluginDetails = (new PluginDetails())
    ->addApplicationName('My e-commerce application')
    ->addApplicationVersion('0.0.1')
    ->addPluginVersion('1.1.0');

$paymentOptions = (new PaymentOptions())
    ->addNotificationUrl('http://www.example.com/client/notification?type=notification')
    ->addRedirectUrl('http://www.example.com/client/notification?type=redirect')
    ->addCancelUrl('http://www.example.com/client/notification?type=cancel')
    ->addCloseWindow(true);

$orderRequest = (new OrderRequest())
    ->addType('redirect')
    ->addOrderId($orderId)
    ->addDescriptionText($description)
    ->addAmount($amount)
    ->addCurrency($currency)
    ->addGatewayCode('IDEAL')
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails)
    ->addPaymentOptions( $paymentOptions);

/** @var TransactionResponse $transaction */
$transactionManager = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
$transactionManager->getPaymentUrl();
```

### Create an order with shopping cart
```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\ValueObject\UnitPrice;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = (string) time();
$description = 'Order #' . $orderId;
$amount = new Amount(12100); // Amount must be in cents
$currency = new Currency('EUR');

$address = (new Address())
    ->addStreetName('Kraanspoor')
    ->addStreetNameAdditional('(blue door)')
    ->addHouseNumber('39')
    ->addZipCode('1033SC')
    ->addCity('Amsterdam')
    ->addState('Noord Holland')
    ->addCountry(new Country('NL'));

$customer = (new CustomerDetails())
    ->addFirstName('John')
    ->addLastName('Doe')
    ->addAddress($address)
    ->addEmailAddress(new EmailAddress('noreply@example.org'))
    ->addPhoneNumber(new PhoneNumber('0208500500'))
    ->addLocale('en_US');

$pluginDetails = (new PluginDetails())
    ->addApplicationName('My e-commerce application')
    ->addApplicationVersion('0.0.1')
    ->addPluginVersion('1.1.0');

$paymentOptions = (new PaymentOptions())
    ->addNotificationUrl('http://www.example.com/client/notification?type=notification')
    ->addRedirectUrl('http://www.example.com/client/notification?type=redirect')
    ->addCancelUrl('http://www.example.com/client/notification?type=cancel')
    ->addCloseWindow(true);

$items[] = (new Item())
    ->addName('Geometric Candle Holders')
    ->addUnitPriceValue(new UnitPrice(50.00)) // Amount must be in whole units
    ->addQuantity(2)
    ->addDescription('1234')
    ->addTaxRate(21)
    ->addMerchantItemId('1234')
    ->addWeight(new Weight('KG', 12));

$orderRequest = (new OrderRequest())
    ->addType('redirect')
    ->addOrderId($orderId)
    ->addDescriptionText($description)
    ->addAmount($amount)
    ->addCurrency($currency)
    ->addGatewayCode('IDEAL')
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails)
    ->addPaymentOptions( $paymentOptions)
    ->addShoppingCart(new ShoppingCart($items));

/** @var TransactionResponse $transaction */
$transactionManager = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
$transactionManager->getPaymentUrl();
```

### Create a direct order with shopping cart and gateway info
Some gateways requires additional information to process a direct transaction; and in this case the information is builded and sended in the gatewayInfo object.

```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\ValueObject\UnitPrice;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = (string) time();
$description = 'Order #' . $orderId;
$amount = new Amount(12100); // Amount must be in cents!!
$currency = new Currency('EUR');

$address = (new Address())
    ->addStreetName('Kraanspoor')
    ->addStreetNameAdditional('(blue door)')
    ->addHouseNumber('39')
    ->addZipCode('1033SC')
    ->addCity('Amsterdam')
    ->addState('Noord Holland')
    ->addCountry(new Country('NL'));

$customer = (new CustomerDetails())
    ->addFirstName('John')
    ->addLastName('Doe')
    ->addAddress($address)
    ->addEmailAddress(new EmailAddress('noreply@example.org'))
    ->addPhoneNumber(new PhoneNumber('0208500500'))
    ->addLocale('nl_NL');

$pluginDetails = (new PluginDetails())
    ->addApplicationName('My e-commerce application')
    ->addApplicationVersion('0.0.1')
    ->addPluginVersion('1.1.0');

$paymentOptions = (new PaymentOptions())
    ->addNotificationUrl('http://www.example.com/client/notification?type=notification')
    ->addRedirectUrl('http://www.example.com/client/notification?type=redirect')
    ->addCancelUrl('http://www.example.com/client/notification?type=cancel')
    ->addCloseWindow(true);

$items[] = (new Item())
    ->addName('Geometric Candle Holders')
    ->addUnitPriceValue(new UnitPrice(50.00))
    ->addQuantity(2)
    ->addDescription('1234')
    ->addTaxRate(21)
    ->addMerchantItemId('1234')
    ->addWeight(new Weight('KG', 12));

$gatewayInfo = (new Ideal())
    ->addIssuerId('3151');
    
$orderRequest = (new OrderRequest())
    ->addType('direct')
    ->addOrderId($orderId)
    ->addDescriptionText($description)
    ->addAmount($amount)
    ->addCurrency($currency)
    ->addGatewayCode('IDEAL')
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails)
    ->addPaymentOptions( $paymentOptions)
    ->addShoppingCart(new ShoppingCart($items))
    ->addGatewayInfo($gatewayInfo);

/** @var TransactionResponse $transaction */
$transaction = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
$transaction->getPaymentUrl();
```

### Creating a full refund without shopping cart
```php
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = XXXXX;  // An order ID created and completed previously
$refundAmount = new Amount(0); // Using zero you will trigger a full refund
$refundCurrency = new Currency('EUR');
$transactionManager = $multiSafepaySdk->getTransactionManager();
$transaction = $transactionManager->get($orderId);
$transactionManager->refund($transaction, (new RefundRequest())->addAmount($refundAmount)->addCurrency($refundCurrency));
```

### Creating a partial refund without shopping cart
```php
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = XXXXX;  // An order ID created and completed previously
$refundAmount = new Amount(2000); // Set the amount that should be refunded in cents
$refundCurrency = new Currency('EUR');
$transactionManager = $multiSafepaySdk->getTransactionManager();
$transaction = $transactionManager->get($orderId);
$transactionManager->refund($transaction, (new RefundRequest())->addAmount($refundAmount)->addCurrency($refundCurrency));
```

### Creating a full refund with shopping cart
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = XXXXX;  // An order ID created and completed previously
$transaction = $multiSafepaySdk->getTransactionManager()->get($orderId);
$refundRequest = $multiSafepaySdk->getTransactionManager()->createRefundRequest($transaction);
$shoppingCart = $transaction->getShoppingCart()->getItems();
foreach ($shoppingCart as $item) {
    $refundRequest->getCheckoutData()->refundByMerchantItemId( (string) $item->getMerchantItemId(), (int) -$item->getQuantity());
}
$multiSafepaySdk->getTransactionManager()->refund( $transaction, $refundRequest );
```

### Creating a partial refund with shopping cart
This request is used for creating a partial refund in orders paid with billing suite payment methods like Pay After Delivery, E-Invoicing, Klarna and AfterPay.

The `$merchantItemId` is some kind of unique value that was initially added while creating the shopping cart. If the `$quantity` is set to zero (`0`) all items identified by `$merchantItemId` are refunded.

To refund multiple items, you can do the following:
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$transaction = $multiSafepaySdk->getTransactionManager()->get($orderId);
$refundRequest = $multiSafepaySdk->getTransactionManager()->createRefundRequest($transaction);
$refundRequest->getCheckoutData()->refundByMerchantItemId($merchantItemId, -1);
$refundRequest->getCheckoutData()->refundByMerchantItemId($merchantItemId , -2);
$refundRequest->getCheckoutData()->refundByMerchantItemId($merchantItemId, -1);
```

### List transactions
Get a list of all transactions for your API Key. 
It is possible to paginate this request using the 'limit' option and the Pager object.
Find all allowed options and more information at our [Documentation Center](https://docs.multisafepay.com/reference/listtransactions/).
```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$options = []; // For all allowed options please check the link to our Documentation Center above.
$transactionListing = $multiSafepaySdk->getTransactionManager()->getTransactions($options);
$transactions = $transactionListing->getTransactions();

$pager = $transactionListing->getPager(); // If pagination is needed, this Pager object can be used 
```

### Pushing a payment request to a Smart POS device
```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Terminal;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
$terminalId = 'your-smart-pos-terminal-id';

$orderId = (string) time();
$description = 'Order #' . $orderId;
$amount = new Amount(12100); // Amount must be in cents!!
$currency = new Currency('EUR');

$address = (new Address())
    ->addStreetName('Kraanspoor')
    ->addStreetNameAdditional('(blue door)')
    ->addHouseNumber('39')
    ->addZipCode('1033SC')
    ->addCity('Amsterdam')
    ->addState('Noord Holland')
    ->addCountry(new Country('NL'));

$customer = (new CustomerDetails())
    ->addFirstName('John')
    ->addLastName('Doe')
    ->addAddress($address)
    ->addEmailAddress(new EmailAddress('noreply@example.org'))
    ->addPhoneNumber(new PhoneNumber('0208500500'))
    ->addLocale('nl_NL');

$pluginDetails = (new PluginDetails())
    ->addApplicationName('My e-commerce application')
    ->addApplicationVersion('0.0.1')
    ->addPluginVersion('1.1.0');

$paymentOptions = (new PaymentOptions())
    ->addNotificationUrl('http://www.example.com/client/notification?type=notification');

$gatewayInfo = (new Terminal())
    ->addTerminalId($terminalId);

$orderRequest = (new OrderRequest())
    ->addType('redirect')
    ->addOrderId($orderId)
    ->addDescriptionText($description)
    ->addAmount($amount)
    ->addCurrency($currency)
    ->addGatewayCode('')
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails)
    ->addPaymentOptions( $paymentOptions)
    ->addGatewayInfo($gatewayInfo);

/** @var \MultiSafepay\Api\Transactions\TransactionResponse $transaction */
$transaction = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
```

## Tokenization
Before working on Tokenization be sure to check out our [Documentation Center](https://docs.multisafepay.com/tools/tokenization/tokenization-api-level/) and that Tokenization is activated on your MultiSafepay account.

### Creating a token
A token can be created by adding a unique 'customer reference' to the customer object, and a 'recurring model' to the orderRequest.
````php
/** \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails $customer */
$customer->addReference('Abc123');

/** \MultiSafepay\Api\Transactions\OrderRequest $orderRequest */
$orderRequest->addRecurringModel('cardOnFile');
````

### Get the tokens
To get the tokens from a reference. You have to use the `\MultiSafepay\Api\TokenManager` Object to receive them.
```php
/** \MultiSafepay\Api\TokenManager $tokenManager */
/** \MultiSafepay\Api\Tokens\Token[] $tokens */
$tokens = $tokenManager->getList('Abc123');
```

### Use a token
To use a token received from the `\MultiSafepay\Api\Tokens\Token`, Use the following request:
```php
/** \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails $customer */
$customer->addReference('Abc123');

/** \MultiSafepay\Api\Transactions\OrderRequest $orderRequest */
$orderRequest->addRecurringModel('cardOnFile');
$orderRequest->addType('direct');
/** \MultiSafepay\Api\Tokens\Token $token */
$orderRequest->addRecurringId($token->getToken());
$orderRequest->addGatewayCode($token->getGatewayCode());
```

### Delete a token
```php
/** \MultiSafepay\Api\TokenManager $tokenManager */
/** \MultiSafepay\Api\Tokens\Token $token */
$tokenManager->delete($token->getToken(),'Abc123');
```

## Verify POST notification request
When receiving the POST notification request, You can verify that the data you received is from MultiSafepay
This can be done by the following
```php
/**
 * @param string|\MultiSafepay\Api\Transactions\TransactionResponse $request the original json data received from MultiSafepay
 * @param string $auth The header named auth in the POST request
 * @param string $apiKey Your API key
 * @param int $validationTimeInSeconds How long the timestamp should be valid from the POST request 
 */
\MultiSafepay\Util\Notification::verifyNotification($request, $auth, $apiKey,$validationTimeInSeconds);
```

## Additional examples
Additional use case examples can be found in the `tests/Functional` folder, even though they might be a bit more complex because of their usage of fixtures.
