#!/bin/bash
vendor/bin/phpcs --standard=phpcs.ruleset.xml . || exit
vendor/bin/phpunit tests || exit
vendor/bin/phpstan analyse src/ tests/ --level 1 || exit
