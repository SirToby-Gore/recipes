<?php

require_once __DIR__ . '/../tools/units.php';
require_once __DIR__ . '/../tools/ingredients.php';

$recipe_id = $recipe_data['recipe-id'] ?? '';
$title_val = $recipe_data['title'] ?? '';
$desc_val = $recipe_data['desc'] ?? '';
$time_val = $recipe_data['time'] ?? '';
$servings_val = $recipe_data['servings'] ?? '';
$tags_val = $recipe_data['tags'] ?? '';
$is_edit_mode = (bool) $edit_recipe;

?>
<div id="form-error-banner" class="form-error-message" style="display: none;"></div>

<form id="recipe-editor-form" onsubmit="submitRecipeForm(event, '<?= $recipe_id ?>')" class="recipe-form">
    <div class="form-group">
        <label for="recipe-title">Recipe Title</label>
        <input type="text" id="recipe-title" value="<?= $title_val ?>" placeholder="e.g., Traditional Shepherd's Pie"
            required>
    </div>

    <div class="form-group">
        <label for="recipe-description">Description</label>
        <textarea id="recipe-description" placeholder="A brief, delicious summary of your dish..."
            required><?= $desc_val ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="recipe-time">Cooking Time (minutes)</label>
            <input type="number" id="recipe-time" value="<?= $time_val ?>" min="1" required>
        </div>
        <div class="form-group">
            <label for="recipe-servings">Servings (portions)</label>
            <input type="number" id="recipe-servings" value="<?= $servings_val ?>" min="1" required>
        </div>
    </div>

    <div class="form-group">
        <label for="recipe-tags">Tags (comma-separated)</label>
        <input type="text" id="recipe-tags" value="<?= $tags_val ?>"
            placeholder="e.g., dinner, beef, comforting, winter">
        <small class="form-hint">Separate tags with commas. No hash symbol (#) needed.</small>
    </div>

    <hr class="form-divider">

    <div class="form-section-header">
        <h3>Method & Ingredients Per Step</h3>
        <p class="section-description">Break your recipe down into steps, and add the ingredients used during each step.
        </p>
    </div>

    <div id="steps-wrapper" class="steps-wrapper">
        <!-- Dynamic steps get appended here by our TS file -->
    </div>

    <div class="form-actions-secondary">
        <button type="button" onclick="addNewFormStep()" class="add-step-btn">
            <span>+</span> Add Another Step
        </button>
    </div>

    <div class="form-actions-primary">
        <a href="<?= $is_edit_mode ? '/recipe/' . $recipe_id : '/' ?>" class="cancel-btn">Cancel</a>
        <button type="submit" class="submit-btn"><?= $is_edit_mode ? 'Save Changes' : 'Publish Recipe' ?></button>
    </div>

    <div hidden id="db-ingredients-data"><?= json_encode($ing_db) ?></div>
    <div hidden id="db-units-data"><?= json_encode(Units::$units_db) ?></div>
    <div hidden id="existing-steps-data"><?= json_encode($recipe_data['steps'] ?? []) ?></div>
</form>