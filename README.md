<p align="center">
  <img src="https://www.multisafepay.com/img/multisafepaylogo.svg" width="400px" position="center">
</p>

# MultiSafepay PHP SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/multisafepay/php-sdk)](https://packagist.org/packages/multisafepay/php-sdk)

## About MultiSafepay ##
MultiSafepay is a collecting payment service provider which means we take care of the agreements, technical details and payment collection required for each payment method. You can start selling online today and manage all your transactions from one place.

## Installation
To install the SDK, use the following composer command:

```bash
composer require multisafepay/php-sdk
```

WARNING: This PHP SDK does not have a direct dependency on Guzzle or cURL.
Instead, it uses the [PSR-18](https://www.php-fig.org/psr/psr-18/) client abstraction and [PSR-17](https://www.php-fig.org/psr/psr-18/) factory abstraction.
This will give you the flexibility to choose whatever [PSR-7 implementation and HTTP client](https://packagist.org/providers/psr/http-client-implementation) you want to use.
All clients can be replaced without any side effects.

If you don't have any client implementation installed, use the following:
```bash
composer require php-http/guzzle6-adapter guzzlehttp/psr7
```

If you don't have any factory implementation installed, use the following:
```bash
composer require http-interop/http-factory-guzzle
```

In short, you need to have installed:
- [PSR-18 client implementation](https://packagist.org/providers/psr/http-client-implementation)
- [PSR-17 factory implementation](https://packagist.org/providers/psr/http-factory-implementation)
- [PSR-7 message implementation](https://packagist.org/providers/psr/http-message-implementation)

## Getting started
Use Composer autoloader to automatically load class dependencies:

```php
require 'vendor/autoload.php';
```

Next, instantiate the SDK with your API key and a flag to identify whether this is the production environment or testing environment.

```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);
```

From the SDK, you can get various managers to help you with what you want to accomplish:
```php
$multiSafepaySdk->getTransactionManager();
$multiSafepaySdk->getGatewayManager();
$multiSafepaySdk->getIssuerManager();
$multiSafepaySdk->getCategoryManager();
```

Of these managers, the transaction manager is probably the most important, because it allows you to create orders and refunds.

```php
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = (string) time();
$description = 'Order #' . $orderId;
$amount = new Money(2000, 'EUR'); // Amount must be in cents!!

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

$pluginDetails = (new PluginDetails)
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
    ->addMoney($amount)
    ->addGatewayCode('IDEAL')
    ->addCustomer($customer)
    ->addDelivery($customer)
    ->addPluginDetails($pluginDetails)
    ->addPaymentOptions( $paymentOptions);

$transactionManager = $multiSafepaySdk->getTransactionManager()->create($orderRequest);
$transactionManager->getPaymentUrl();
```

And here's an example of a refund:
```php
// Refund example.
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\ValueObject\Money;

$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new \MultiSafepay\Sdk($yourApiKey, $isProduction);

$orderId = XXXXX;  // An order ID created and completed previously
$refundAmount = new Money(2000, 'EUR');
$transactionManager = $multiSafepaySdk->getTransactionManager();
$transaction = $transactionManager->get($orderId);
$transactionManager->refund($transaction, (new RefundRequest())->addMoney( $refundAmount ) );
```

See [USAGE.md](USAGE.md) and the functional tests in `tests/Functional/Api/Transactions` for examples on how to build full requests.

## Advanced usage: The Strict Mode
The SDK is by default initialize in a non-strict mode (by setting its constructor argument `$strictMode` to `false`). This strict mode adds additional validations on top of various API requests and API responses. In the non-strict mode (the default) some validation errors are skipped. In the strict mode, these validation errors throw an exception, which requires you to handle the exception correspondingly.

For example, take a `ShoppingCart` object that is to be added to an `OrderRequest` object. This `ShoppingCart` might be filled with items and each item might have a specific taxrate (referring to the `TaxTables` object). Summing up the total price of these items might lead to an amount with more than 2 decimals. However, if the e-commerce application requires a payment only of the amount in 2 decimals, this causes a mismatch. In the strict mode, this mismatch causes an `\MultiSafepay\Exception\InvalidTotalAmountException` exception. However, it depends on the e-commerce application and also the payment gateway to determine how this mismatch should be solved. Hence, the exception is only throw when the strict mode is enabled.

In the tests of the SDK, the strict mode is enabled.

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

The following definitions have been made regarding tests:

- Unit tests: Tests that work without the actual API and without any dependencies (`tests/Unit`)
- Integration tests: Tests that work without the actual API but with dependencies (`tests/Integration`)
- Functional tests: Tests that work with a live API (`tests/Functional`)

Only for running functional tests, a API key is required.

#### Running unit tests

To run either unit tests of this package, use the following steps:

- Clone this repository somewhere.
- Run `composer install` to install all dependencies
- Run PHPUnit with one of the following commands:
  - `./vendor/bin/phpunit tests/Unit`

#### Running functional tests

To run functional tests of this package, use the following steps:

- Clone this repository somewhere.
- Run `composer install` to install all dependencies
- Copy `.env.php.example` to `.env.php` and add your own MultiSafepay API key
- Run PHPUnit with one of the following commands:
  - `./vendor/bin/phpunit tests/Functional`

#### Mocking the API for unit and integration tests

Unit and integration tests run without the actual API, which means that the client is mocking all actual data calls. To do so, the folder `tests/fixture-data` contains JSON files to help spoofing calls. To fill this folder with actual real-life data, make sure you have a valid `.env.php` file and use the following command:

    php tests/generateApiMocks.php

It is the intention to commit all generated JSON files into git, so that they serve as fixtures. Files that are not used in tests, are not needed to be generated.

## Support
You can create issues on our repository. If you need any additional help or support, please contact <a href="mailto:integration@multisafepay.com">integration@multisafepay.com</a>

## A gift for your contribution
We look forward to receiving your input. Have you seen an opportunity to change things for better? We would like to invite you to create a pull request on GitHub.
Are you missing something and would like us to fix it? Suggest an improvement by sending us an [email](mailto:integration@multisafepay.com) or by creating an issue.

What will you get in return? A brand new designed MultiSafepay t-shirt which will make you part of the team!

## License
[Open Software License (OSL 3.0)](https://github.com/MultiSafepay/php-sdk/blob/master/LICENSE.md)

## Want to be part of the team?
Are you a developer interested in working at MultiSafepay? [View](https://www.multisafepay.com/careers/#jobopenings) our job openings and feel free to get in touch with us.
