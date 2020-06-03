#!/bin/bash
vendor/bin/phpcs --standard=phpcs.ruleset.xml .
vendor/bin/phpunit tests
vendor/bin/phpstan analyse src/ tests/ --level 1
