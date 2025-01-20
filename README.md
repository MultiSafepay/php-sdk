<p align="center">
    <img src="https://raw.githubusercontent.com/MultiSafepay/MultiSafepay-logos/master/MultiSafepay-logo-color.svg" width="400px" position="center">
</p>

# MultiSafepay PHP SDK

[![Latest stable version](https://img.shields.io/packagist/v/multisafepay/php-sdk)](https://packagist.org/packages/multisafepay/php-sdk)

## About MultiSafepay
MultiSafepay is a Dutch payment services provider, which takes care of contracts, processing transactions, and collecting payment for a range of local and international payment methods. Start selling online today and manage all your transactions in one place!

## Installation
Run the following composer command:

```bash
composer require multisafepay/php-sdk
```

**WARNING!** This SDK does **not** have a direct dependency on Guzzle or cURL.
Instead, it uses the [PSR-18](https://www.php-fig.org/psr/psr-18/) client abstraction and [PSR-17](https://www.php-fig.org/psr/psr-18/) factory abstraction.
This lets you choose which [PSR-7 implementation and HTTP client](https://packagist.org/providers/psr/http-client-implementation) to use.
You can replace all clients without any side effects.

If you don't have a client implementation installed, run:
```bash
composer require guzzlehttp/guzzle
```

If you don't have a factory implementation installed, run:
```bash
composer require http-interop/http-factory-guzzle
```

You should now have installed:
- [PSR-18 client implementation](https://packagist.org/providers/psr/http-client-implementation)
- [PSR-17 factory implementation](https://packagist.org/providers/psr/http-factory-implementation)
- [PSR-7 message implementation](https://packagist.org/providers/psr/http-message-implementation)

## Getting started
Use Composer autoloader to automatically load class dependencies:

```php
require 'vendor/autoload.php';
```

Next, instantiate the SDK with your [site API key](https://docs.multisafepay.com/docs/sites#site-id-api-key-and-security-code) and a flag to identify whether this is the live environment or testing environment.

```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
```

From the SDK, you can get various managers:
```php
$multiSafepaySdk->getTransactionManager();
$multiSafepaySdk->getGatewayManager();
$multiSafepaySdk->getPaymentMethodManager();
$multiSafepaySdk->getIssuerManager();
$multiSafepaySdk->getCategoryManager();
$multiSafepaySdk->getTokenManager();
$multiSafepaySdk->getApiTokenManager();
```

The transaction manager is the most important, because it lets you create orders and refunds.

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
$amount = new Amount(2000); // Amount must be in cents!!
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

$transactionManager = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
$transactionManager->getPaymentUrl();
```

Example refund:
```php
// Refund example.
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = XXXXX;  // The order ID of a previously completed transaction
$refundAmount = new Amount(2000);
$refundCurrency = new Currency('EUR');
$transactionManager = $multiSafepaySdk->getTransactionManager();
$transaction = $transactionManager->get($orderId);
$transactionManager->refund($transaction, (new RefundRequest())->addAmount($refundAmount)->addCurrency($refundCurrency));
```

For examples of building full requests, see [USAGE.md](USAGE.md) and the functional tests in `tests/Functional/Api/Transactions`.

## Advanced usage: Strict mode
Strict mode:
- Adds additional validations on top of various API requests and responses.
- Validation errors throw an exception, which you need to handle.
- It is enabled in tests.

Non-strict mode (default) skips some validation errors.

**Example:**
If there is a mismatch between the number of decimal places of the total amount of the items in the `ShoppingCart` object and your ecommerce platform, strict mode throws an `\MultiSafepay\Exception\InvalidTotalAmountException` exception.

## Code quality checks
The following checks are in place to maintain code quality:

- PHP CodeSniffer (via `./vendor/bin/phpcs --standard=phpcs.ruleset.xml .`)
  - PSR-2
  - Object Calisthenics
- PHPUnit tests (via `./vendor/bin/phpunit`)
  - Unit tests
  - Integration tests
  - Functional tests

## Testing

- Unit tests work without the API or any dependencies (`tests/Unit`)
- Integration tests work without the API but have dependencies (`tests/Integration`)
- Functional tests work with the live API (`tests/Functional`) – API key required

#### Unit tests

To run unit tests from this package:

1. Clone this repository.
2. To install all dependencies, run `composer install`
3. Run PHPUnit with the following command: `./vendor/bin/phpunit tests/Unit`

#### Functional tests

To run functional tests from this package:

1. Clone this repository.
2. To install all dependencies, run `composer install`.
3. Copy `.env.php.example` to `.env.php` and add your site API key.
4. Run PHPUnit with the following command: `./vendor/bin/phpunit tests/Functional`

#### Mocking the API for unit and integration tests

Unit and integration tests run without the API, which means that the client is mocking all data calls.
To do this, the `tests/fixture-data` folder contains JSON files to spoof calls. To fill this folder with real data, make sure you have a valid `.env.php` file, and then use the following command:

    php tests/generateApiMocks.php

This commits all generated JSON files into git, so that they serve as fixtures. Files that are not used in tests don't need to be generated.

## Support
Create an issue on this repository or email <a href="mailto:integration@multisafepay.com">integration@multisafepay.com</a>

## Contributors
If you create a pull request to suggest an improvement, we'll send you some MultiSafepay swag as a thank you!

## License
[Open Software License (OSL 3.0)](https://github.com/MultiSafepay/php-sdk/blob/master/LICENSE.md)

## Want to be part of the team?
Are you a developer interested in working at MultiSafepay? Check out our [job openings](https://www.multisafepay.com/careers/#jobopenings) and feel free to get in touch!
