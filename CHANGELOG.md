# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
