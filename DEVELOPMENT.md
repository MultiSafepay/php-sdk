# Notes on development
This library is developed by MultiSafepay to support multiple PHP-based e-commerce systems.

## Creating a new release
- Increment the version in `composer.json`
    - Tagging can not be the only source of versioning (like composer recommends), because the library will also be used on systems that don't use composer.
- Add a new entry in `CHANGELOG.md`
- Create a new GitHub release
