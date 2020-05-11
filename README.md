# MultiSafepay PHP SDK

## Installation

```bash
composer require multisafepay/php-sdk php-http/guzzle6-adapter guzzlehttp/psr7
```

This PHP SDK does not have a dependency on Guzzle or cURL.
Instead, it uses the [PSR-18](https://www.php-fig.org/psr/psr-18/) client abstraction.
This will give you the flexibility to choose whatever
[PSR-7 implementation and HTTP client](https://packagist.org/providers/php-http/client-implementation)
you want to use.
All clients can be replaced without any side effects.

## Getting started

Use Composer autoloader to automatically load your dependencies. 

```php
require 'vendor/autoload.php';
use MultiSafepay\Sdk;
```

Next, instantiate the API with your API key and a flag to identify whether this is the production environment or testing environment.

```php
$yourApiKey = 'your-api-key';
$isProduction = false;
$multiSafepaySdk = new Sdk($yourApiKey, $isProduction);
```


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
