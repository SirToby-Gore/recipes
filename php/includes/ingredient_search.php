<?php
// Layout architecture required to inject the dynamic elements established in the controller
?>
<section class="ingredient-search-wrapper" style="max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem;">

    <!-- Top Filter UI -->
    <div class="filter-section"
        style="background: #ffffff; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <h2 style="color: #1b4332; margin-bottom: 0.5rem;">Search by Ingredients</h2>
        <p style="color: #718096; margin-bottom: 1.5rem; font-size: 0.95rem;">Type to fuzzy find ingredients, add them
            to your list, and instantly find recipes that match.</p>

        <!-- Selected Tags Container -->
        <div id="selected-ingredients-container"
            style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1rem;"></div>

        <!-- Input & Search Trigger -->
        <div style="position: relative; display: flex; gap: 1rem; align-items: flex-start; max-width: 600px;">
            <div style="position: relative; flex: 1;">
                <input type="text" id="ingredient-fuzzy-input" autocomplete="off"
                    placeholder="Type an ingredient (e.g. Garlic...)"
                    style="width: 100%; padding: 0.85rem 1rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 1rem; outline: none;">

                <div id="fuzzy-dropdown"
                    style="display: none; position: absolute; top: calc(100% + 4px); left: 0; width: 100%; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; max-height: 250px; overflow-y: auto; z-index: 1000; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <!-- Matches injected via TS here -->
                </div>
            </div>
            <button id="search-ingredients-btn"
                style="background: #1b4332; color: #ffffff; border: none; padding: 0.85rem 1.5rem; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.2s;">Find
                Recipes</button>
        </div>
    </div>

    <!-- Conditional Focus Description (When exactly 1 item is selected) -->
    <?php if (isset($focus_ingredient) && $focus_ingredient): ?>
        <div class="ingredient-focus-header"
            style="background: #ffffff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid #2d6a4f; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <h2 style="color: #1b4332; margin-bottom: 0.5rem;"><?= htmlspecialchars($focus_ingredient->name) ?></h2>
            <p><strong>Description:</strong> <?= htmlspecialchars($focus_ingredient->description) ?></p>

            <?php if (!empty($substitutions)): ?>
                <div class="ingredient-substitutions" style="margin-top: 1.5rem;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Available Substitutes:</h3>
                    <ul style="list-style-type: disc; padding-left: 1.5rem;">
                        <?php foreach ($substitutions as $sub): ?>
                            <li style="margin-bottom: 0.25rem;">
                                <strong><?= htmlspecialchars($sub['substitute_name']) ?>:</strong>
                                <em style="color: #555;"><?= htmlspecialchars($sub['substitution_context']) ?></em>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Render Match Proportional Recipe Output -->
    <?php if (!empty($recipes)): ?>
        <h3 style="margin-bottom: 1rem; color: #1b4332;">Matching Recipes (<?= count($recipes) ?>)</h3>

        <div class="recipes" style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
            <?php foreach ($recipes as $recipe_data): ?>
                <div style="position: relative; flex: 0 0 auto;">

                    <?php
                    $recipe_obj = Recipe::from_id($recipe_data['recipe_id']);
                    if ($recipe_obj) {
                        echo render_recipe_card($recipe_obj);
                    }
                    ?>

                    <!-- Proportional Accuracy Overlay -->
                    <div
                        style="position: absolute; top: -10px; right: -10px; background: #2d6a4f; color: #ffffff; padding: 6px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                        <?= round(($recipe_data['matching_ingredients_count'] / $recipe_data['total_recipe_ingredients']) * 100) ?>%
                        Match
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif (!empty($selected_ingredients)): ?>
        <p style="color: #718096; font-size: 1.1rem;">No recipes completely match your selection. Try removing some
            ingredients to broaden your search.</p>
    <?php endif; ?>

    <!-- Safely pass PHP arrays to TS environment -->
    <div hidden id="all-ingredients-data"><?= json_encode($all_ingredients ?? []) ?></div>
    <div hidden id="selected-ingredients-data"><?= json_encode($selected_ingredients ?? []) ?></div>

</section>