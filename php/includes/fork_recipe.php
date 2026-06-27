<?php
require_once __DIR__ . '/../tools/ingredients.php';

if (!$account) {
    header('Location: /login');
    exit;
}

if (!$edit_recipe) {
    header('Location: /');
    exit;
}

// Track parent ID via reference variable
$parent_recipe_id = $edit_recipe->recipe_id;
$recipe_id ??= '';
$is_edit_mode = false;

// Prefill form values using the origin recipe properties
$title_val ??= ($edit_recipe->title ? $edit_recipe->title . ' (Fork)' : '');
$desc_val ??= ($edit_recipe->description ?? '');
$time_val ??= ($edit_recipe->total_time ?? '');
$servings_val ??= ($edit_recipe->portions ?? '');

// Convert tag collection into comma-separated string
$tags_val ??= implode(', ', array_map(fn ($tag) => $tag->tag_name, $edit_recipe->get_tags()));

// Rebuild step payload structure for the shared form base
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
<div class="recipe-form-container" data-parent-id="<?= htmlspecialchars($parent_recipe_id) ?>">
    <h2>Fork Recipe: <?= htmlspecialchars($edit_recipe->title) ?></h2>
    <?php require __DIR__ . '/_recipe_form_base.php'; ?>
</div>