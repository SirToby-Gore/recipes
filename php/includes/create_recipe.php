<?php
require_once __DIR__ . '/../tools/ingredients.php';

// Only use default empty strings if they weren't already provided by a failed submit state
$recipe_id ??= '';
$title_val ??= '';
$desc_val ??= '';
$time_val ??= '';
$servings_val ??= '';
$tags_val ??= '';
$is_edit_mode ??= false;
$recipe_steps_payload ??= [];

$ing_db ??= [];
?>
<div class="recipe-form-container">
    <h2>Create New Recipe</h2>
    <?php require __DIR__ . '/_recipe_form_base.php'; ?>
</div>