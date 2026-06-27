<?php
require_once __DIR__ . '/../init.php';

if (!$account) {
    header('Location: /login');
    exit;
}

$basket_items = $account->get_baskets();

$aggregated_ingredients = [];

foreach ($basket_items as $item) {
    $recipe = Recipe::from_id($item->recipe_id);
    if (!$recipe) {
        continue;
    }

    $portions_multiplier = (float) $item->amount;

    foreach ($recipe->get_ingredients_list() as $ingredients_list) {
        $ingredient = $ingredients_list->get_ingredient();
        $unit = $ingredients_list->get_unit();
        if (!$ingredient || !$unit) {
            continue;
        }

        $source_shorthand = $unit->short_hand;
        $category = $unit_categories[$source_shorthand] ?? 'count';
        $source_amount = (float) $ingredients_list->amount * $portions_multiplier;

        if ($category === 'count') {
            if (!isset($aggregated_ingredients[$ingredient->ingredient_id])) {
                $aggregated_ingredients[$ingredient->ingredient_id] = [
                    'name' => $ingredient->name,
                    'amount' => 0.0,
                    'unit' => $source_shorthand,
                    'category' => $ingredient->category,
                ];
            }
            $aggregated_ingredients[$ingredient->ingredient_id]['amount'] += $source_amount;
        } else {
            $base_shorthand = ($category === 'mass') ? 'g' : 'ml';
            $base_unit_id = $unit_mappings[$base_shorthand];
            $source_unit_id = $unit_mappings[$source_shorthand] ?? $unit->unit_id;

            $to_base_multiplier = get_multiplier_to_base($source_unit_id, $base_unit_id);
            $amount_in_base = $source_amount * $to_base_multiplier;

            $target_shorthand = $region_targets[$preferred_region][$category];
            $target_unit_id = $unit_mappings[$target_shorthand];

            $from_base_multiplier = get_multiplier_to_base($target_unit_id, $base_unit_id);
            $final_amount = $amount_in_base / $from_base_multiplier;

            if (!isset($aggregated_ingredients[$ingredient->ingredient_id])) {
                $aggregated_ingredients[$ingredient->ingredient_id] = [
                    'name' => $ingredient->name,
                    'amount' => 0.0,
                    'unit' => $target_shorthand,
                    'category' => $ingredient->category,
                ];
            }
            $aggregated_ingredients[$ingredient->ingredient_id]['amount'] += $final_amount;
        }
    }
}

uasort($aggregated_ingredients, fn ($a, $b) => $a['category'] <=> $b['category']);

?>

<section class="basket-full">
    <h3>Your Shopping Basket</h3>

    <?php global $preferred_region ?>
    <div class="preference-selector recipe-unit-switcher">
        <label for="recipe-region-select">View Ingredients In:</label>
        <select id="recipe-region-select" onchange="updateUserRegionPreference(this.value)">
            <option value="metric" <?= $preferred_region === 'metric' ? 'selected' : '' ?>>Metric (g, ml)</option>
            <option value="us" <?= $preferred_region === 'us' ? 'selected' : '' ?>>US Customary (oz, cups)</option>
            <option value="uk" <?= $preferred_region === 'uk' ? 'selected' : '' ?>>UK Imperial (oz, imperial cups)</option>
        </select>
    </div>

    <br>

    <?php if (empty($basket_items)): ?>
        <div class="empty-basket">
            <p>Your basket is currently empty. Browse some recipes to add ingredients!</p>
            <a href="/" class="profile-button">Browse Recipes</a>
        </div>
    <?php else: ?>
        <div class="basket-list">
            <?php foreach ($basket_items as $item): ?>
                <?php
                $recipe = Recipe::from_id($item->recipe_id);
                $recipe_title = $recipe ? htmlspecialchars($recipe->title) : 'Unknown Recipe';
                ?>
                <div class="basket-item">
                    <span class="item-name"><?= $recipe_title ?></span>

                    <div class="basket-management-group" data-recipe-id="<?= $recipe->recipe_id ?>">
                        <a href="javascript:void(0)" onclick="handleBasketDecrement('<?= $recipe->recipe_id ?>')"
                            class="decrement-btn" aria-label="Decrease quantity">-</a>
                        <span class="recipe-count-display"><?= $item->amount ?></span>
                        <a href="javascript:void(0)" onclick="handleBasketIncrement('<?= $recipe->recipe_id ?>')"
                            class="increment-btn" aria-label="Increase quantity">+</a>
                        <a href="javascript:void(0)" onclick="handleBasketRemove('<?= $recipe->recipe_id ?>')"
                            class="remove-btn" aria-label="Remove item">Remove</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <br>

        <div class="ingredients-list">
            <h3>Shopping List</h3>
            <ul class="shopping-list-items">
                <?php foreach ($aggregated_ingredients as $ingredient_id => $display_item): ?>
                    <?php
                    $formatted_amount = round($display_item['amount'], 2);
                    $display_unit = htmlspecialchars($display_item['unit']);

                    $shopping_list_item_db = ShoppingListItem::from_id($account->user_id, $ingredient_id);
                    $is_checked = $shopping_list_item_db ? $shopping_list_item_db->is_checked : false;
                    ?>
                    <li class="shopping-list-item <?= $is_checked ? 'checked' : '' ?>">
                        <input type="checkbox" onchange="handleToggleIngredientCheck(this, '<?= $ingredient_id ?>')"
                            <?= $is_checked ? 'checked' : '' ?>>
                        <span class="ingredient-quantity"><?= $formatted_amount ?>         <?= $display_unit ?></span>
                        <span class="ingredient-name"><?= htmlspecialchars($display_item['name']) ?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>
</section>