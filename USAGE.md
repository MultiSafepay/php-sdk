# Example usage of the SDK
To use the SDK, the SDK first needs to be instantiated. See the **Getting Started** section in [README.md](README.md). All examples below assume an instantiated SDK object named `$multiSafepaySdk`.

### Getting a list of gateways
```php
/** @var \MultiSafepay\Api\Gateways\Gateway[] $gateways **/
$gateways = $multiSafepaySdk->getGatewayManager()->getGateways();
```

### Get a specific gateway
```php
/** @var \MultiSafepay\Api\Gateways\Gateway $gateway **/
$gateway = $multiSafepaySdk->getGatewayManager()->getByCode('VISA');
```

### Get a list of categories
```php
/** @var \MultiSafepay\Api\Categories\Category[] $categories **/
$categories = $multiSafepaySdk->getCategoryManager()->getCategories();
```

### Get a list of iDEAL issuers
```php
/** @var \MultiSafepay\Api\Issuers\Issuer[] $issuers **/
$issuers = $multiSafepaySdk->getIssuerManager()->getIssuersByGatewayCode('IDEAL');
```

### Create an order
```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\IpAddress;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\TransactionResponse;
 
$orderId = 42;
$description = 'foobar';

$country = new Country('NL');

$address = (new Address())
    ->addStreetName('Kraanspoor')
    ->addStreetNameAdditional('(blue door)')
    ->addHouseNumber('39')
    ->addHouseNumberSuffix('')
    ->addZipCode('1033SC')
    ->addCity('Amsterdam')
    ->addState('Noord Holland')
    ->addCountry($country);

$customer = (new CustomerDetails())
    ->addFirstName('John')
    ->addLastName('Doe')
    ->addAddress($address)
    ->addIpAddress(new IpAddress('10.0.0.1'))
    ->addEmailAddress(new EmailAddress('info@example.org'))
    ->addPhoneNumber(new PhoneNumber('0612345678'))
    ->addLocale('nl_NL')
    ->addReferrer('http://example.org')
    ->addForwardedIp(new IpAddress('192.168.1.1'))
    ->addData(['something' => 'else'])
    ->addUserAgent('Unknown');

$pluginDetails = (new PluginDetails)
    ->addApplicationName('My e-commerce application')
    ->addApplicationVersion('0.0.1');

$orderRequest = (new OrderRequest())
    ->addOrderId($orderId)
    ->addDescriptionText($description)
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails);

/** @var TransactionResponse $transaction */
$transaction = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
```

### Adding a shopping cart to an order
Most orders also require a shopping cart to be added. This can be created by adding items to a cart:
```php
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item;

$items = [(new Item())
    ->addName('Geometric Candle Holders')
    ->addUnitPrice(new Money(5000, 'EUR'))
    ->addQuantity(2)
    ->addDescription('1234')
    ->addTaxRate(21)
    ->addTaxTableSelector('none')
    ->addMerchantItemId('1234')
    ->addWeight(new Weight('KG', 12));

$shoppingCart = new ShoppingCart($items);
$orderRequest->addShoppingCart($shoppingCart);
```

Each item has an `addTaxRate` method that does not actually add an entry to the JSON data of the item itself. Instead, this tax rate is used to automatically construct table rates, that are added to the checkout options of the same order request. These checkout options can be manually added to the order request via a method `addCheckoutOptions`. But in practice, it is often enough to simply have these checkout options automatically be generated via the shopping cart instead.

### Creating a refund
Creating a refund is easiest by using the shortcut methods in the TransactionManager:
```php
$transaction = $multiSafepaySdk->getTransactionManager()->get($orderId);
$multiSafepaySdk->getTransactionManager()->refundByItem($transaction, $merchantItemId, $quantity = 0);
```
The `$merchantItemId` is some kind of unique value that was initially added while creating the shopping cart. If the `$quantity` is set to zero (`0`) all items identified by `$merchantItemId` are refunded.

To refund multiple items, you can do the following:
```php
$transaction = $multiSafepaySdk->getTransactionManager()->get($orderId);
$refundRequest = $multiSafepaySdk->getTransactionManager()->createRefundRequest($transaction);
$refundRequest->getCheckoutData()->refundByMerchantItemId('example1', 1);
$refundRequest->getCheckoutData()->refundByMerchantItemId('example2', 2);
$refundRequest->getCheckoutData()->refundByMerchantItemId('example3', 1);
```

### Additional examples
Additional real-life examples can be found in the `tests/Functional` folder, even though they might be a bit more complex because of their usage of fixtures.

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
