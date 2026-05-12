<?php

require_once __DIR__ . '/../init.php';

require_once __DIR__ . '/account.php';
require_once __DIR__ . '/allergen.php';
require_once __DIR__ . '/allergy.php';
require_once __DIR__ . '/comment.php';
require_once __DIR__ . '/ingredient_list.php';
require_once __DIR__ . '/ingredient.php';
require_once __DIR__ . '/recipe.php';
require_once __DIR__ . '/step.php';
require_once __DIR__ . '/substitution.php';
require_once __DIR__ . '/tag.php';
require_once __DIR__ . '/token.php';
require_once __DIR__ . '/unit.php';
require_once __DIR__ . '/user.php';

function get_data_from_id(string $table, mixed $id, string $id_column = 'id'): ?array {
    global $connection;

    $types = '';

    switch (gettype($id)) {
        case 'string':
            $types = 's';
            break;

        case 'integer':
            $types = 'i';
            break;

        default:
            return null;
    }

    // Prepare statement with concatenated table name - NOT SAFE FOR PRODUCTION
    $sql = "SELECT * FROM `$table` WHERE `$id_column`=?";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        // Handle error, maybe log it
        return null;
    }

    $stmt->bind_param($types, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    return $result;
}
