<?php

require_once __DIR__ . '/_functions.php';

/**
 * Generates a cryptographically secure random hexadecimal string.
 */
function random_string(int $length): string
{
    return bin2hex(random_bytes(intdiv($length, 2)));
}

/**
 * Generates a unique 32-character database identifier using database lookups.
 */
function new_uuid(string $field_name, string $table_name): string
{
    global $conn;

    $stmt = $conn->prepare("SELECT 1 FROM `$table_name` WHERE `$field_name` = ? LIMIT 1");

    while (true) {
        $new_id = random_string(32);
        $stmt->bind_param('s', $new_id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            return $new_id;
        }
    }
}

/**
 * Generates a unique 64-character session/reset token.
 */
function new_token(): string
{
    global $conn;

    $stmt = $conn->prepare("SELECT 1 FROM `Tokens` WHERE `token` = ? LIMIT 1");

    while (true) {
        $new_id = random_string(64);
        $stmt->bind_param('s', $new_id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            return $new_id;
        }
    }
}

/**
 * Generates a unique 38-character database identifier using optimized queries.
 */
function new_long_uuid(string $field_name, string $table_name): string
{
    global $conn;

    $stmt = $conn->prepare("SELECT 1 FROM `$table_name` WHERE `$field_name` = ? LIMIT 1");

    while (true) {
        $new_id = random_string(38);
        $stmt->bind_param('s', $new_id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            return $new_id;
        }
    }
}

/**
 * Generates a unique safe integer ID up to 1024, preventing infinite loops if range is exhausted.
 */
function new_int_id(string $field_name, string $table_name): int
{
    global $conn;

    $stmt = $conn->prepare("SELECT 1 FROM `$table_name` WHERE `$field_name` = ? LIMIT 1");
    $attempts = 0;

    while ($attempts < 500) {
        $new_id = random_int(0, 1024);
        $stmt->bind_param('i', $new_id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            return $new_id;
        }
        $attempts++;
    }

    throw new Exception("ID range space exhausted in table: $table_name");
}

/**
 * Obtains the current system datetime string.
 */
function datetime_now(): string
{
    return date('Y-m-d H:i:s');
}

/**
 * Removes target elements from a plain array up to an optional count.
 */
function array_remove(mixed $needle, array &$haystack, int $max_removals = -1): array
{
    $new_haystack = [];
    $removals_count = 0;

    foreach ($haystack as $value) {
        if ($value === $needle && ($max_removals === -1 || $removals_count < $max_removals)) {
            $removals_count++;
            continue;
        }
        $new_haystack[] = $value;
    }

    return $new_haystack;
}

function is_unit_compatible(Unit $unit, Ingredient $ingredient, bool $terminal = false): bool
{
    global $conn;

    $stmt = $conn->prepare('SELECT `unit_id` FROM `IngredientsUsedInSteps` WHERE `ingredient_id`=? LIMIT 1');
    $stmt->bind_param('s', $ingredient->ingredient_id);
    $stmt->execute();

    $unit_id = $stmt->get_result()->fetch_assoc()['unit_id'] ?? null;

    if (null == $unit_id) {
        return true;
    }

    $check_unit = Unit::from_id((int) $unit_id);

    if (!$check_unit) {
        return true;
    }

    if ($check_unit->unit_id == $unit->unit_id) {
        return true;
    }

    if (
        in_array(
            $unit->unit_id,
            array_map(
                fn ($unit) => $unit->new_unit,
                $check_unit->get_compatible_units_by_base_unit()
            )
        )
    ) {
        return true;
    }

    if ($terminal) {
        echo "Unit {$unit->short_hand} is not compatible with {$check_unit->short_hand}";
    }

    return false;
}