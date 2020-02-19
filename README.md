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

## Usage example

Use Composer autoloader to automatically load your dependencies. 

```php
require 'vendor/autoload.php';
use MultiSafepay\Api;
```
