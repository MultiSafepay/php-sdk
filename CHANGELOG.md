# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [5.16.0] - 2025-03-19
### Added
- PHPSDK-166: Add support for affiliates & split payments to create order endpoint
- PHPSDK-168: Add unit tests for covering IPV6 in IpAddress class
- PLGMAG2V2-401: Add new type 'checkout' to the allowed types in the OrderRequest class
- PLGMAG2V2-401: Add new 'feed_url' methods to the OrderRequest class

### Fixed
- PHPSDK-143: Trim merchant item id in order request

## [5.15.0] - 2025-01-27
### Added
- PHPSDK-158: Add "Amount" and "UnitPrice" objects and deprecate the Money object
- PHPSDK-160: Add missing request parameters to UpdateRequest, like excludeOrder, extendExpiration, reason, partialShipmentAmount, carrier, invoiceId, invoiceUrl, poNumber, shipDate, trackTraceCode, trackTraceUrl, newOrderId
- PHPSDK-159: Add support within the SDK to get the QR related properties
- PHPSDK-154: Add cart validation to replace strict mode in the future

### Fixed
- PHPSDK-163: Fix PHP 8.4 deprecations, thanks to @RV7PR
- PLUGINSUP-637: Fix missing MultiSafepay logo in README document, thanks to @DaanDeSmedt
- PHPSDK-162: Use correct case for emandate property, thanks to @malles

### Changed
- PHPSDK-164: Overwrite max amount for gift cards to be null, because these might accept partial payment

## [5.14.0] - 2024-07-08
### Added
- PHPSDK-155: Throw ApiUnavailableException when API returns 501/503 HTTP codes
- PHPSDK-156: Add getGatewayId in TransactionResponse class

## [5.13.0] - 2024-04-16
### Added
- PHPSDK-151: Update Gateways::SHOPPING_CART_REQUIRED_GATEWAYS adding 'BNPL_INST', 'IN3B2B', 'SANTANDER', 'ZINIA', 'ZINIA_IN3', 'BNPL_OB', 'BNPL_MF' gateways codes

## [5.12.1] - 2024-03-11
### Fixed
- PHPSDK-146: Fix ApiException not being hinted as a thrown exception, even though it is, by fixing the PHP DocBlocks @throws tags

## [5.12.0] - 2023-12-01
### Added
- PHPSDK-139: Add support to set var1, var2 and var3, within the OrderRequest object
- PHPSDK-140: Add support to set custom_info, within the OrderRequest object, thanks to @DaanDeSmedt

## [5.11.2] - 2023-10-13
### Fixed
- PHPSDK-134: Fix errors when only reference is set, within the CustomerDetails object

### Changed
- PHPSDK-136: Remove PluginDetails as mandatory from the Order Request

## [5.11.1] - 2023-07-31
### Added
- PHPSDK-128: Add new methods to set the properties within the MerchantSessionRequest object

## [5.11.0] - 2023-07-10
### Added
- DAVAMS-654: Add new method in TokenManager to return the tokens as array

### Changed
- PLGMIRAKL-2: Change the visibility of the "client" class property, within the Sdk class, from private to protected

## [5.10.0] - 2023-05-18
### Added
- PHPSDK-124: Add support to set the terminal ID within the OrderRequest, pushing a payment request to the Smart POS terminal

### Fixed
- PHPSDK-125: Improvement over the IPAddress class, adding in the PHP Docblock the exception it might throw up

## [5.9.0] - 2023-02-20
### Added
- DAVAMS-568: Add deprecated notice for GoogleAnalytics class. Will be removed in version 7.0.0
- DAVAMS-600: Add BNPL_INSTM as a gateway which requires the shopping cart within the orderRequest
- PHPSDK-116: Add isCoupon function to PaymentMethod object

### Changed
- PHPSDK-118: Return as true that a payment method supports Payment Components, without fields, but with tokenization
- PHPSDK-117: Refactor ALLOWED_TYPES and ALLOWED_RECURRING_MODELS constants in the OrderRequest class


## [5.8.0] - 2022-12-05
### Added
- PHPSDK-85: Add support for "payment-methods" endpoint
- MAGWIRE-3: Add support for accessing the pluginDetails object from the OrderRequest to enable overwriting its data
- PLGMAG2V2-488: Add methods to the OrderRequest to retrieve the ShoppingCart, CheckoutOptions and TaxTable objects
- PHPSDK-112: Add the raw_response_body of a request to the context, to always have the actual response available that was retrieved from an API request

### Fixed
- PHPSDK-113: Fix an issue where the locale argument was being overwritten in GET requests, even if it was already defined

## [5.7.0] - 2022-10-24
### Added
- PHPSDK-99: Trim API-KEY in signature validation
- PHPSDK-96: Add method to get GatewayInfo object from the OrderRequest object

### Fixed
- PHPSDK-97: Fix a bug in which OrderRequest->get('key') returns null
- PHPSDK-107: Fix issuer listing when response from API is an empty array (Thanks to @barryvdh)

## [5.6.0] - 2022-07-12
### Added
- PHPSDK-94: Support for listing transactions 
- DAVAMS-491: Add GatewayInfo object for MyBank issuers

### Changed
- Sdk class: save the tokenManager as a class variable to avoid creating new instances
- TokenManager: Reduce the amount of API calls when getting tokens by gateway

### Fixed
- PHPSDK-98: Fix the filter for allowed options in the GatewayManager

## [5.5.0] - 2022-05-11
### Added
- PHPSDK-90: Add MAESTRO tokens within the results of the CREDITCARD tokens request

### Changed
- PHPSDK-91: Add trim on API key when initializing the SDK

## [5.4.0] - 2021-11-30
### Added
- Added the AccountManager class which can be used for retrieving MultiSafepay account data

### Changed
- Updated the API token endpoint url to use 'json' instead of 'connect', since 'connect' will be deprecated

## [5.3.1] - 2021-10-29
### Added
- Added possibility to add settings along with payment options in the transaction request


## [5.3.0] - 2021-10-15
### Added
- Added support for [Apple Pay direct payment method](https://docs.multisafepay.com/payment-methods/apple-pay/direct/)
- Add class WalletManager which can be used for getting specific data needed for wallets payment methods

## [5.2.2] - 2021-09-30
### Fixed
- Fixed a bug where some addresses that start with a number would return null.

## [5.2.1] - 2021-09-06
### Fixed
- Fixed a bug where a refund could not be created if the orderId parameter wasn't provided.

## [5.2.0] - 2021-08-27
### Added
- Added support for [API manual capture endpoints](https://docs.multisafepay.com/api/#manual-capture-orders)

## [5.1.1] - 2021-07-13
### Changed
- Removal of phone number filtering in PhoneNumber value object.

## [5.1.0] - 2021-06-01
### Changed
- Deprecation of duplicate method TransactionResponse->getPaymentLink().

### Added
- Add support for [API token endpoint](https://docs.multisafepay.com/api/#generate-an-api-token)
- Add class ShippingItem in OrderRequest which can be used for simpler way to specify a shipping item in the [shopping cart](https://docs.multisafepay.com/api/#shopping-cart-items)
- Add [POST notification validation](https://docs.multisafepay.com/faq/api/notification-url/#validating-post-notifications)

### Fixed
- Fix bug when requesting transaction details for an order registered without a ShoppingCart returning InvalidArgumentException with clear error message

## [5.0.1] - 2021-03-11
### Changed
- getGateways will now include all merchant enabled gift cards by default
- Prevent validation error on comma-separated IP addresses, now using first IP address
- Remove type hint for CartItem quantity to allow for float values

## [5.0.0] - 2021-02-17
### Added
- Add support for PHP 8.0

### Removed
- Removed support for PHP 7.1

## [4.1.0] - 2021-02-03
### Added
- Add support for company_name in Customer object
- Add support for tokenization
- Add new method in TransactionResponse object to check if requires shopping cart to process refunds.
- Add new methods to simplify how to set properties in multiple objects

## [4.0.3] - 2020-12-17
### Fixed
- Fixed overwriting tax rules in shopping cart when tax rates are too close in range
- Fixed TypeError when quantity in Weight is not a float

## [4.0.2] - 2020-11-24
### Fixed
- Fixed PHP rounding issues when casting amount to int

## [4.0.1] - 2020-10-26
### Fixed
- Fix wrong namespace for QrEnabled class

### Changed
- Remove html tags from item name, item description in CartItem, and from order description in OrderRequest

## [4.0.0] - 2020-09-11
### Removed
- Removed obsolete support for `country_name`
- Removed dependency on `league/iso3166`
- Removed dependency on `ext-bcmath`

### Changed
- Added dependency on `psr/http-client-implementation`
- Added dependency on `psr/http-message-implementation`
- Added dependency on `psr/http-factory-implementation` 

## [3.0.2] - 2020-09-03
### Fixed
- Fix bug where issuers wouldn't be able to load because of wrong issuer code type (int instead of string)

## [3.0.1] - 2020-09-02
### Fixed
- SDK_VERSION constant is now up to date

## [3.0.0] - 2020-08-19
### Fixed
- Make sure QrCode `min_amount` and `max_amount` make sense
- Fix call to undefined method negative when using refundByMerchantItemId 

### Removed
- Removed `phone2` and `addPhoneNumbers()` from `Customer` class

## [2.0.0] - 2020-07-07
### Removed
- Changed `Money\Money` into custom ValueObject `MultiSafepay\ValueObject\Money`. Make sure to update all code.

### Fixed
- Allow for unknown gateway codes to be used as well
- Removed postcode and state from tax rates, because they are not implemented in API
- Additional unit tests

## [1.0.0] - 2020-06-05
### Added
- First public release with coverage of all previous functionality
