<?php

require_once __DIR__ . '/../init.php';

require_once __DIR__ . '/_units.php';
require_once __DIR__ . '/_ingredients.php';
require_once __DIR__ . '/_recipes.php';

$conn->query('DELETE FROM `Users` WHERE 1');

$recipe_user = new User(
    new_uuid('user_id', 'Users'),
    'Recipe Seeder',
    '',
    random_string(32),
    '',
    datetime_now()
);
$recipe_user->password_hash = user_hash_password(random_string(256), $recipe_user->salt);
$recipe_user->create();

$conn->query('DELETE FROM `Recipes` WHERE 1');

foreach ($recipes_assoc as $recipe) {

    echo "Creating recipe: {$recipe['name']}:\n";

    $new_recipe = new Recipe(
        new_uuid('recipe_id', 'Recipes'),
        $recipe['name'],
        $recipe['description'],
        $recipe['timeMinutes'],
        $recipe['servings'],
        null,
        $recipe_user->user_id
    );
    $new_recipe->create();
    echo "created recipe instance\n";

    foreach ($recipe['tags'] as $tag) {
        $new_tag = new Tag($new_recipe->recipe_id, $tag);
        $new_tag->create();
        echo "created tag: {$tag}\n";
    }

    $i = 1;

    foreach ($recipe['steps'] as $step) {
        $new_step = new Step(new_long_uuid('step_id', 'Steps'), $i++, $new_recipe->recipe_id, $step['step']);
        $new_step->create();
        echo "created step: {$step['step']}\n";

        if (!array_key_exists('ingredients', $step)) {
            continue;
        }

        foreach ($step['ingredients'] as $ingredient) {
            if (!is_unit_compatible($ingredient['unit'], $ingredient['id'], terminal: true)) {
                die("Issue with ingredients, units are incompatible on ingredient " . $ingredient['id']->name . ", on recipe id:" . $recipe['id']);
            }

            $ingredient_used = new IngredientsUsedInStep(
                $new_step->step_id,
                $ingredient[
                    'id']->ingredient_id,
                $ingredient['amount'],
                $ingredient['unit']->unit_id
            );
            $ingredient_used->create();
            echo "created ingredient in step: {$ingredient['id']->name}\n";
        }
    }
    echo "finished creating recipe\n\n";
}

echo "\nDone\n";

