<?php
require_once __DIR__ . '/../init.php';

if (!$account) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['preferred_region'])) {
    $_SESSION['preferred_region'] = $_POST['preferred_region'];
}

$preferred_region = $_SESSION['preferred_region'] ?? 'metric';
$basket_items = $account->get_baskets();

$unit_categories = [
    'piece' => 'count',
    'clove' => 'count',
    'pinch' => 'count',
    'g' => 'mass',
    'kg' => 'mass',
    'oz (us)' => 'mass',
    'lb (us)' => 'mass',
    'oz (uk)' => 'mass',
    'lb (uk)' => 'mass',
    'stone (uk)' => 'mass',
    'ml' => 'volume',
    'l' => 'volume',
    'tsp (us)' => 'volume',
    'tbsp (us)' => 'volume',
    'fl oz (us)' => 'volume',
    'cup (us)' => 'volume',
    'pint (us)' => 'volume',
    'quart (us)' => 'volume',
    'gallon (us)' => 'volume',
    'tsp (uk)' => 'volume',
    'tbsp (uk)' => 'volume',
    'fl oz (uk)' => 'volume',
    'cup (uk)' => 'volume',
    'pint (uk)' => 'volume',
    'quart (uk)' => 'volume',
    'gallon (uk)' => 'volume',
    'cup (metric)' => 'volume'
];

$unit_mappings = [
    'piece' => 1,
    'clove' => 2,
    'pinch' => 3,
    'g' => 4,
    'kg' => 5,
    'ml' => 6,
    'l' => 7,
    'oz (us)' => 8,
    'lb (us)' => 9,
    'oz (uk)' => 10,
    'lb (uk)' => 11,
    'stone (uk)' => 12,
    'tsp (us)' => 13,
    'tbsp (us)' => 14,
    'fl oz (us)' => 15,
    'cup (us)' => 16,
    'pint (us)' => 17,
    'quart (us)' => 18,
    'gallon (us)' => 19,
    'tsp (uk)' => 20,
    'tbsp (uk)' => 21,
    'fl oz (uk)' => 22,
    'cup (uk)' => 23,
    'pint (uk)' => 24,
    'quart (uk)' => 25,
    'gallon (uk)' => 26,
    'cup (metric)' => 27
];

$region_targets = [
    'metric' => ['mass' => 'g', 'volume' => 'ml'],
    'us' => ['mass' => 'oz (us)', 'volume' => 'cup (us)'],
    'uk' => ['mass' => 'oz (uk)', 'volume' => 'cup (uk)']
];

function get_multiplier_to_base(int $source_unit_id, int $base_unit_id): float
{
    global $conn;
    if ($source_unit_id === $base_unit_id) {
        return 1.0;
    }
    $stmt = $conn->prepare("SELECT `multiplier` FROM `CompatibleUnits` WHERE `base_unit` = ? AND `new_unit` = ?");
    $stmt->bind_param('ii', $base_unit_id, $source_unit_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if ($result) {
        return (float) $result['multiplier'];
    }
    $stmt = $conn->prepare("SELECT `multiplier` FROM `CompatibleUnits` WHERE `base_unit` = ? AND `new_unit` = ?");
    $stmt->bind_param('ii', $source_unit_id, $base_unit_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if ($result) {
        return 1.0 / (float) $result['multiplier'];
    }
    return 1.0;
}

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

    <div class="region-selector-container">
        <form method="POST" action="/basket">
            <label for="preferred_region">Preferred System:</label>
            <select name="preferred_region" id="preferred_region" onchange="this.form.submit()">
                <option value="metric" <?= $preferred_region === 'metric' ? 'selected' : '' ?>>Metric (g, ml)</option>
                <option value="us" <?= $preferred_region === 'us' ? 'selected' : '' ?>>US Customary (oz, cup)</option>
                <option value="uk" <?= $preferred_region === 'uk' ? 'selected' : '' ?>>UK Imperial (oz, cup)</option>
            </select>
        </form>
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