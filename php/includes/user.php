<section class="recipes">
    <?php foreach ($user->get_recipes() as $recipe): ?>
        <?= recipe_card($recipe) ?>
    <?php endforeach ?>
</section>