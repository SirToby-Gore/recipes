<?php

require_once __DIR__ . '/_functions.php';

/**
 * Fetches the currently authenticated user from session.
 */
function get_account(): ?User
{
    if (!isset($_SESSION['account'])) {
        $_SESSION['account'] = null;
    }

    return $_SESSION['account'];
}

/**
 * Registers an active user object into session.
 */
function set_account(?User $account): void
{
    $_SESSION['account'] = $account;
}

/**
 * Fetches the active authentication token from session.
 */
function get_token(): ?Token
{
    return $_SESSION['token'] ?? null;
}

/**
 * Registers an active session token into session.
 */
function set_token(?Token $token): void
{
    $_SESSION['token'] = $token;
}

/**
 * Lazy loads a user's details from session cache or database.
 */
function get_user(string $id): ?User
{
    if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    if (!isset($_SESSION['users'][$id])) {
        $_SESSION['users'][$id] = User::from_id($id);
    }

    return $_SESSION['users'][$id];
}

/**
 * Forces a fresh database query to refresh a cached user.
 */
function force_get_user(string $id): ?User
{
    if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    $_SESSION['users'][$id] = User::from_id($id);

    return $_SESSION['users'][$id];
}

/**
 * Verifies if an email address is already registered.
 */
function email_in_use(string $email): bool
{
    global $conn;

    $stmt = $conn->prepare("SELECT `email` FROM `Users` WHERE `email` = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();

    return $stmt->get_result()->num_rows > 0;
}

/**
 * Verifies if a name is already taken (maps to correct schema column 'name').
 */
function name_in_use(string $name): bool
{
    global $conn;

    $stmt = $conn->prepare("SELECT `username` FROM `Users` WHERE `username` = ? LIMIT 1");
    $stmt->bind_param('s', $name);
    $stmt->execute();

    return $stmt->get_result()->num_rows > 0;
}

/**
 * Produces a secure, deterministic hash using PBKDF2.
 */
function user_hash_password(string $password, string $salt): string
{
    return hash_pbkdf2("sha256", $password, $salt, 100000, 0);
}

/**
 * Authenticates user credentials, sets session cache context, and logs token records.
 */
function login(string $email, string $password): bool
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM `Users` WHERE `email` = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $user_assoc = $stmt->get_result()->fetch_assoc();
    if (!$user_assoc) {
        return false;
    }

    if (user_hash_password($password, $user_assoc['salt']) !== $user_assoc['password_hash']) {
        return false;
    }

    // Hydrate User entity safely using direct key access
    set_account(new User(
        $user_assoc['user_id'],
        $user_assoc['username'],
        $user_assoc['email'],
        $user_assoc['salt'],
        $user_assoc['password_hash'],
        $user_assoc['created_on']
    ));

    $token = new Token(new_token(), $user_assoc['user_id'], datetime_now());
    $token->create();

    set_token($token);

    $user = get_account();

    $_SESSION['liked-recipes'] = array_map(fn ($rec) => $rec->recipe_id, $user->get_recipe_likes());
    $_SESSION['favourited-recipes'] = array_map(fn ($rec) => $rec->recipe_id, $user->get_recipe_favourites());

    return true;
}