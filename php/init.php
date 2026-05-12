<?php

declare(strict_types=1);

require_once __DIR__ . '/php-html/php-html.php';

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/classes/_classes.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = parse_ini_file(filename: '.env');

$connection = new mysqli(
    hostname: $env_data['hostname'],
    username: $env_data['username'],
    password: $env_data['password'],
    database: $env_data['database'],
);

Token::clear_old_tokens();

$account = Account::get_account();


