<?php

require_once __DIR__ . '/../init.php';

$recipes = [];
$users = [];

if (!$search_term) {
    $recipes = search_recipes_by_name('');
}

if (str_starts_with($search_term, '@')) {
    $search_term = substr($search_term, 1);

    $users = search_users_for($search_term);

    goto _exit;
}

if (str_starts_with($search_term, '#')) {
    $search_term = substr($search_term, 1);

    $recipes = search_recipes_by_tag($search_term);

    goto _exit;
}

if ($search_term) {
    $users = search_users_for($search_term);

    $recipes = search_recipes_by_name($search_term);

    if (empty($recipes)) {
        $recipes = search_recipes_by_tag($search_term);
    }

    goto _exit;
}

_exit:

?>

<?php if ((count($recipes) + count($users)) == 0): ?>
    <section class="recipes warning">
        Sorry no Recipes or Users found for "<?= $search_term ?>"
    </section>
<?php else: ?>
    <?php if ($recipes): ?>
        <section class="recipes">
            <details open>
                <summary>
                    <h3>Recipes</h3>
                </summary>
                <div class="recipes">
                    <?php foreach ($recipes as $recipe): ?>
                        <?= render_recipe_card($recipe) ?>
                    <?php endforeach ?>
                </div>
            </details>
        </section>
    <?php endif ?>

    <?php if ($users): ?>
        <section class="users">
            <details open>
                <summary>
                    <h3>Users</h3>
                </summary>
                <div class="users">
                    <?php foreach ($users as $user): ?>
                        <?= render_user_card($user) ?>
                    <?php endforeach ?>
                </div>
            </details>
        </section>
    <?php endif ?>
<?php endif ?>