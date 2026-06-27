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
    <?php if (0 === count($user->get_recipes())): ?>
        <p>No recipes yet</p>
        <?php if ($user->user_id === ($account ?? Blank::$user)->user_id): ?>
            <br>
            <a href="/recipe/create">Create your first recipe</a>
        <?php endif ?>
    <?php else: ?>
        <?php foreach ($user->get_recipes() as $recipe): ?>
            <?= render_recipe_card($recipe) ?>
        <?php endforeach ?>
    <?php endif ?>
</section>