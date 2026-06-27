<?php
require_once __DIR__ . '/../tools/ingredients.php';

if (!$account) {
    header('Location: /login');
}

if (!$edit_recipe) {
    header('Location: /');
}

$recipe_id ??= ($edit_recipe->recipe_id ?? '');
$is_edit_mode = true;

$title_val ??= ($edit_recipe->title ?? '');
$desc_val ??= ($edit_recipe->description ?? '');
$time_val ??= ($edit_recipe->total_time ?? '');
$servings_val ??= ($edit_recipe->portions ?? '');

$tags_val ??= implode(', ', array_map(fn ($tag) => $tag->tag_name, $edit_recipe->get_tags()));

if (!isset($recipe_steps_payload)) {
    $recipe_steps_payload = [];

    $steps = $edit_recipe->get_steps();

    uasort($steps, fn ($a, $b) => $a->step_number <=> $b->step_number);

    foreach ($steps as $step) {
        $step_assoc = [];

        $step_assoc['step'] = $step->step;

        $step_assoc['ingredients'] = $step->get_ingredients_used_in_steps();

        $recipe_steps_payload[] = $step_assoc;
    }
}


$ing_db ??= [];
?>
<div class="recipe-form-container">
    <h2>Modify Existing Recipe</h2>
    <?php require __DIR__ . '/_recipe_form_base.php'; ?>
</div>