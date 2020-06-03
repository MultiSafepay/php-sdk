#!/bin/bash
vendor/bin/phpcs --standard=phpcs.ruleset.xml . || exit
vendor/bin/phpunit tests/Unit || exit
vendor/bin/phpunit tests/Integration || exit
vendor/bin/phpstan analyse --no-progress src/ tests/ --level 1 || exit
