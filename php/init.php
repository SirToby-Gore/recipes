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
