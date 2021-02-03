# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
