<?php

require_once __DIR__ . '/_functions.php';

function has_user_liked_recipe(Recipe $recipe): bool
{
    global $account;

    if (!$account) {
        return false;
    } else {
        return RecipeLike::from_id($recipe->recipe_id, $account->user_id) != null;
    }
}
function has_user_favourited_recipe(Recipe $recipe): bool
{
    global $account;

    if (!$account) {
        return false;
    } else {
        return RecipeFavourite::from_id($recipe->recipe_id, $account->user_id) != null;
    }
}

/**
 * Toggles the like status of a recipe for a user, updating database and session state.
 */
function toggle_recipe_like(string $recipe_id, string $user_id): void
{
    $like = RecipeLike::from_id($recipe_id, $user_id);
    if ($like) {
        $like->delete();
    } else {
        $like = new RecipeLike($recipe_id, $user_id);
        $like->create();
    }
}

/**
 * Toggles the favourite status of a recipe for a user, updating database and session state.
 */
function toggle_recipe_favourite(string $recipe_id, string $user_id): void
{
    $favourite = RecipeFavourite::from_id($recipe_id, $user_id);
    if ($favourite) {
        $favourite->delete();
    } else {
        $favourite = new RecipeFavourite($recipe_id, $user_id);
        $favourite->create();
    }
}

/**
 * Adds all ingredients of a recipe to the user's active shopping list/basket.
 */
function add_recipe_to_basket(string $recipe_id, string $user_id): void
{
    $recipe = Recipe::from_id($recipe_id);
    if ($recipe) {
        $ingredients = $recipe->get_ingredients_list();
        foreach ($ingredients as $item) {
            $basket_item = Basket::from_id($user_id, $item->ingredient_id);
            if ($basket_item) {
                $basket_item->amount += $item->amount;
                $basket_item->update();
            } else {
                $basket_item = new Basket(
                    $recipe_id,
                    $user_id,
                    1,
                );
                $basket_item->create();
            }
        }
    }
}

function create_shopping_list(Recipe $recipe)
{
    global $account;

    foreach ($recipe->get_ingredients_list() as $recipe_ingredient) {
        $unit_id = isset($recipe_ingredient->unit_id) ? $recipe_ingredient->unit_id : ($recipe_ingredient->unit ?? null);

        $existing_item = ShoppingListItem::from_id($account->user_id, $recipe_ingredient->ingredient_id);

        if ($existing_item) {
            $existing_item->amount += $recipe_ingredient->amount;
            $existing_item->update();
        } else {
            $new_item = new ShoppingListItem(
                $account->user_id,
                $recipe_ingredient->ingredient_id,
                $recipe->recipe_id,
                $recipe_ingredient->amount,
                $unit_id,
                false,
            );
            $new_item->create();
        }
    }
}

function update_shopping_list(Recipe $recipe, Basket $basket_item): void
{
    global $account;

    $recipe_ingredients = [];
    foreach ($recipe->get_ingredients_list() as $ingredient) {
        $recipe_ingredients[$ingredient->ingredient_id] = $ingredient;
    }

    foreach ($account->get_shopping_list_items() as $item) {
        if ($item->recipe_id !== $recipe->recipe_id) {
            continue;
        }

        if (isset($recipe_ingredients[$item->ingredient_id])) {
            $item->amount = $recipe_ingredients[$item->ingredient_id]->amount * $basket_item->amount;
            $item->update();
        }
    }
}

function delete_shopping_list(Recipe $recipe)
{
    global $account;
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `ShoppingListItems` WHERE `user_id`=? AND `recipe_id`=?");
    $stmt->bind_param('ss', $account->user_id, $recipe->recipe_id);
    $stmt->execute();
}

