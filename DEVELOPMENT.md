# Notes on development
This library is developed by MultiSafepay to support multiple PHP-based e-commerce systems.

## Creating a new release
1) New PRs (or any changes) are documented in `CHANGELOG.md` by following the [KeepAChangelog](https://keepachangelog.com/en/1.0.0/) standard:
    - Changes are documented as `Added`, `Changed`, `Removed` or `Fixed`
    - A section `## [Unreleased]` is kept in the top at all times.
    - New PRs are added via lines under `## [Unreleased]` while making a reference to the PR number or URL
2) To make a new release, the lines under `## [Unreleased]` are copied into a new release section (`## [1.0.0] - 2001-01-01`), following the semantic versioning standard: Third digit increases with bug fixes, second digit (minor) increases with new features, first digit (major) increases with backward incompatibility changes.
3) The constant `SDK_VERSION` in the class `MultiSafepay\Util\Version` needs to be updated with the new version.
4) The `version` in the `composer.json` is changed with the new version.
5) A new release is created in GitHub manually.
6) The new release is copied from the internal repository to the public repository.
