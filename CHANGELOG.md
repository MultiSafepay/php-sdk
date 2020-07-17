# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Fixed
- Make sure QrCode `min_amount` and `max_amount` make sense

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
