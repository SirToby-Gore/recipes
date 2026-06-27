<?php
require_once __DIR__ . '/../functions/html_elements.php';
require_once __DIR__ . '/../tools/units.php';

$session_error = $_SESSION['form_error'] ?? null;
unset($_SESSION['form_error']); // Clear it immediately so it doesn't persist
?>

<div id="form-error-banner" class="form-error-message"
    style="<?= $session_error ? 'display: block;' : 'display: none;' ?>">
    <?= htmlspecialchars($session_error ?? '') ?>
</div>

<form id="recipe-editor-form" onsubmit="submitRecipeForm(event, '<?= htmlspecialchars($recipe_id) ?>')"
    class="recipe-form">

    <?php
    echo render_form_input('recipe-title', 'Recipe Title', 'text', $title_val, 'e.g., Traditional Shepherd\'s Pie', true);

    echo render_form_textarea('recipe-description', 'Description', $desc_val, 'A brief, delicious summary of your dish...', true);
    ?>

    <div class="form-row">
        <?php
        echo render_form_number_input('recipe-time', 'Cooking Time (minutes)', $time_val, 1, true);
        echo render_form_number_input('recipe-servings', 'Servings (portions)', $servings_val, 1, true);
        ?>
    </div>

    <?php
    echo render_form_input(
        'recipe-tags',
        'Tags (comma-separated)',
        'text',
        $tags_val,
        'e.g., dinner, beef, comforting, winter',
        false,
        'Separate tags with commas. No hash symbol (#) needed.'
    );

    echo render_form_divider();

    echo render_form_section_header(
        'Method & Ingredients Per Step',
        'Break your recipe down into steps, and add the ingredients used during each step.'
    );
    ?>

    <div id="steps-wrapper" class="steps-wrapper"></div>

    <div class="form-actions-secondary">
        <button type="button" onclick="addNewFormStep()" class="add-step-btn">
            <span>+</span> Add Another Step
        </button>
    </div>

    <?php
    echo render_form_actions($is_edit_mode, $recipe_id);
    ?>

    <div hidden id="db-ingredients-data"><?= json_encode($ing_db) ?></div>
    <div hidden id="db-units-data"><?= json_encode(Units::$units_db) ?></div>
    <div hidden id="existing-steps-data"><?= json_encode($recipe_steps_payload) ?></div>
</form>