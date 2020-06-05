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
$gateway = $multiSafepaySdk->getGatewayManager()->getGateway('VISA');
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
    ->addAddress($this->createAddressFixture())
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

### Additional examples
Additional real-life examples can be found in the `tests/Functional` folder, even though they might be a bit more complex because of their usage of fixtures.
