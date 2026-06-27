<?php if ($account): ?>
    <section>
        <?php global $preferred_region ?>
        <div class="preference-selector recipe-unit-switcher">
            <label for="recipe-region-select">View Ingredients In:</label>
            <select id="recipe-region-select" onchange="updateUserRegionPreference(this.value)">
                <option value="metric" <?= $preferred_region === 'metric' ? 'selected' : '' ?>>Metric (g, ml)</option>
                <option value="us" <?= $preferred_region === 'us' ? 'selected' : '' ?>>US Customary (oz, cups)</option>
                <option value="uk" <?= $preferred_region === 'uk' ? 'selected' : '' ?>>UK Imperial (oz, imperial cups)</option>
            </select>
        </div>
    </section>
<?php endif ?>

<section class="recipes">
    <?php foreach ($user->get_recipes() as $recipe): ?>
        <?= render_recipe_card($recipe) ?>
    <?php endforeach ?>
</section>