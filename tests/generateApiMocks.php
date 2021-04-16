<?php
use MultiSafepay\Tests\Utils\MockGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

$mockGenerator = new MockGenerator();
$mockGenerator->generateGetRequests([
    'json/gateways',
    'json/categories',
]);
