<?php
require_once __DIR__ . '/../init.php';

if (!$account) {
    header('Location: /login');
    exit;
}

$favourite_recipes = $account->get_favourite_recipes();
?>

<section class="favourites-container">
    <div class="page-header">
        <h2>Your Favourite Recipes</h2>
        <p>A curated list of your top culinary choices.</p>
    </div>

    <?php if (empty($favourite_recipes)): ?>
        <div class="empty-favourites">
            <p>You haven't added any recipes to your favourites list yet.</p>
            <a href="/" class="profile-button">Explore Recipes</a>
        </div>
    <?php else: ?>
        <section class="recipes">
            <?php foreach ($favourite_recipes as $recipe): ?>
                <?= render_recipe_card($recipe) ?>
            <?php endforeach ?>
        </section>s
    <?php endif; ?>
</section>