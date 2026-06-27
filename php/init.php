<?php

declare(strict_types=1);

require_once __DIR__ . '/classes/_classes.php';
require_once __DIR__ . '/functions/_functions.php';
require_once __DIR__ . '/static_vars.php';

$env = parse_ini_file('.env');

$conn = new mysqli(
    hostname: $env['hostname'],
    username: $env['username'],
    password: $env['password'],
    database: $env['database'],
);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$account = get_account();

$preferred_region = $_SESSION['preferred_region'] ?? 'metric';

$unit_categories = [
    'piece' => 'count',
    'clove' => 'count',
    'pinch' => 'count',
    'g' => 'mass',
    'kg' => 'mass',
    'oz (us)' => 'mass',
    'lb (us)' => 'mass',
    'oz (uk)' => 'mass',
    'lb (uk)' => 'mass',
    'stone (uk)' => 'mass',
    'ml' => 'volume',
    'l' => 'volume',
    'tsp (us)' => 'small-volume',
    'tbsp (us)' => 'small-volume',
    'fl oz (us)' => 'volume',
    'cup (us)' => 'volume',
    'pint (us)' => 'volume',
    'quart (us)' => 'volume',
    'gallon (us)' => 'volume',
    'tsp (uk)' => 'small-volume',
    'tbsp (uk)' => 'small-volume',
    'fl oz (uk)' => 'volume',
    'cup (uk)' => 'volume',
    'pint (uk)' => 'volume',
    'quart (uk)' => 'volume',
    'gallon (uk)' => 'volume',
    'cup (metric)' => 'volume'
];

$unit_mappings = [
    'each' => 1,
    'mg' => 2,
    'g' => 3,
    'kg' => 4,
    'ml' => 5,
    'l' => 6,
    'oz (us)' => 7,
    'lb (us)' => 8,
    'oz (uk)' => 9,
    'lb (uk)' => 10,
    'stone (uk)' => 11,
    'tsp (us)' => 12,
    'tbsp (us)' => 13,
    'fl oz (us)' => 14,
    'cup (us)' => 15,
    'pint (us)' => 16,
    'quart (us)' => 17,
    'gallon (us)' => 18,
    'tsp (uk)' => 19,
    'tbsp (uk)' => 20,
    'fl oz (uk)' => 21,
    'cup (uk)' => 22,
    'pint (uk)' => 23,
    'quart (uk)' => 24,
    'gallon (uk)' => 25,
    'cup (metric)' => 26,
    'dessertspoon' => 27,
    'tbsp (au)' => 28,
    'cup (jp)' => 29
];

$region_targets = [
    'metric' => [
        'mass' => 'g',
        'volume' => 'ml',
        'small-volume' => 'ml'
    ],
    'us' => [
        'mass' => 'oz (us)',
        'volume' => 'cup (us)',
        'small-volume' => 'tsp (us)'
    ],
    'uk' => [
        'mass' => 'oz (uk)',
        'volume' => 'cup (uk)',
        'small-volume' => 'tsp (uk)'
    ]
];

