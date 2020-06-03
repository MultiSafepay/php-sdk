#!/bin/bash
vendor/bin/phpcs --standard=phpcs.ruleset.xml .
vendor/bin/phpunit tests/Unit
vendor/bin/phpunit tests/Integration
vendor/bin/phpstan analyse src/ tests/ --level 1
