<?php

/**
 * Searches users based on username matching parameters, ranking exact and prefix matches first.
 */
function search_users_for(string $search_term): array
{
    global $conn;

    $users = [];
    $trimmed_term = trim($search_term);

    if ($trimmed_term === '') {
        return $users;
    }

    $exact_match = $trimmed_term;
    $prefix_match = $trimmed_term . "%";
    $any_match = "%" . $trimmed_term . "%";

    // Weighted query: Exact matches score 100, prefixes score 50, middle matches score 10
    $stmt = $conn->prepare(<<<SQL
        SELECT *,
            (CASE 
                WHEN `username` = ? THEN 100
                WHEN `username` LIKE ? THEN 50
                ELSE 10
            END) AS `relevance`
        FROM `Users` 
        WHERE `username` LIKE ? 
        ORDER BY `relevance` DESC, `username` ASC 
        LIMIT 100
    SQL);
    $stmt->bind_param('sss', $exact_match, $prefix_match, $any_match);
    $stmt->execute();

    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $users[] = new User(
            $row['user_id'],
            $row['username'],
            $row['email'],
            $row['salt'],
            $row['password_hash'],
            $row['created_on'],
            $row['unit_preference']
        );
    }

    return $users;
}

/**
 * Searches and ranks recipes matching tag strings, ordering strictly by exact tag match and popularity.
 */
function search_recipes_by_tag(string $search_term): array
{
    global $conn;

    $recipes = [];
    $trimmed_term = trim($search_term);

    if ($trimmed_term === '') {
        return $recipes;
    }

    $exact_match = $trimmed_term;
    $prefix_match = $trimmed_term . "%";
    $any_match = "%" . $trimmed_term . "%";

    // Joins with the correct RecipeLikes table to sort by popularity within relevance brackets
    $stmt = $conn->prepare(<<<SQL
        SELECT `Recipes`.*,
            (CASE 
                WHEN `Tags`.`tag_name` = ? THEN 100
                WHEN `Tags`.`tag_name` LIKE ? THEN 50
                ELSE 10
            END) AS `relevance`
        FROM `Recipes` 
        JOIN `Tags` ON `Recipes`.`recipe_id` = `Tags`.`recipe_id` 
        LEFT JOIN `RecipeLikes` ON `Recipes`.`recipe_id` = `RecipeLikes`.`recipe_id`
        LEFT JOIN `RecipeFavourites` ON `Recipes`.`recipe_id` = `RecipeFavourites`.`recipe_id`
        WHERE `Tags`.`tag_name` LIKE ?
        GROUP BY `Recipes`.`recipe_id`
        ORDER BY 
            `relevance` DESC, 
            COUNT(DISTINCT `RecipeLikes`.`user_id`) DESC, 
            COUNT(DISTINCT `RecipeFavourites`.`user_id`) DESC, 
            `Recipes`.`title` ASC
        LIMIT 150
    SQL);
    $stmt->bind_param('sss', $exact_match, $prefix_match, $any_match);
    $stmt->execute();

    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $recipes[] = new Recipe(
            $row['recipe_id'],
            $row['title'],
            $row['description'],
            (int) $row['total_time'],
            (int) $row['portions'],
            $row['parent'],
            $row['user_id']
        );
    }

    return $recipes;
}

/**
 * Searches recipes by direct name or description matches with smart relevance weighting and popularity sorting.
 */
function search_recipes_by_name(string $search_term): array
{
    global $conn;

    $recipes = [];
    $trimmed_term = trim($search_term);

    if ($trimmed_term === '') {
        // Safe default fallback query for landing pages sorting by likes, favourites, and name
        $stmt = $conn->prepare(<<<SQL
            SELECT `Recipes`.*
            FROM `Recipes` 
            LEFT JOIN `RecipeLikes` ON `Recipes`.`recipe_id` = `RecipeLikes`.`recipe_id`
            LEFT JOIN `RecipeFavourites` ON `Recipes`.`recipe_id` = `RecipeFavourites`.`recipe_id`
            GROUP BY `Recipes`.`recipe_id`
            ORDER BY 
                COUNT(DISTINCT `RecipeLikes`.`user_id`) DESC, 
                COUNT(DISTINCT `RecipeFavourites`.`user_id`) DESC, 
                `Recipes`.`title` ASC
            LIMIT 150
        SQL);
    } else {
        $exact_match = $trimmed_term;
        $prefix_match = $trimmed_term . "%";
        $any_match = "%" . $trimmed_term . "%";

        // Scoring rules: Exact title match > title starts-with > title contains > description contains
        $stmt = $conn->prepare(<<<SQL
            SELECT `Recipes`.*,
                (CASE 
                    WHEN `Recipes`.`title` = ? THEN 100
                    WHEN `Recipes`.`title` LIKE ? THEN 50
                    WHEN `Recipes`.`title` LIKE ? THEN 30
                    ELSE 10
                END) AS `relevance`
            FROM `Recipes` 
            LEFT JOIN `RecipeLikes` ON `Recipes`.`recipe_id` = `RecipeLikes`.`recipe_id`
            LEFT JOIN `RecipeFavourites` ON `Recipes`.`recipe_id` = `RecipeFavourites`.`recipe_id`
            WHERE `Recipes`.`title` LIKE ? OR `Recipes`.`description` LIKE ?
            GROUP BY `Recipes`.`recipe_id`
            ORDER BY 
                `relevance` DESC, 
                COUNT(DISTINCT `RecipeLikes`.`user_id`) DESC, 
                COUNT(DISTINCT `RecipeFavourites`.`user_id`) DESC, 
                `Recipes`.`title` ASC
            LIMIT 150
        SQL);
        $stmt->bind_param('sssss', $exact_match, $prefix_match, $any_match, $any_match, $any_match);
    }

    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $recipes[] = new Recipe(
            $row['recipe_id'],
            $row['title'],
            $row['description'],
            (int) $row['total_time'],
            (int) $row['portions'],
            $row['parent'],
            $row['user_id']
        );
    }

    return $recipes;
}


