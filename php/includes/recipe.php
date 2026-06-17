<?php

$current_user = get_account() ?? Blank::$user;
$user_id = (isset($current_user->user_id) && $current_user->user_id) ? $current_user->user_id : null;

$safe_title = htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8');
$safe_author_name = htmlspecialchars($recipe->get_user()->username, ENT_QUOTES, 'UTF-8');

$is_liked = $user_id ? (RecipeLike::from_id($recipe->recipe_id, $user_id) !== null) : false;
$is_favourited = $user_id ? (RecipeFavourite::from_id($recipe->recipe_id, $user_id) !== null) : false;

$like_status = $is_liked ? 'liked' : 'like';
$favourite_status = $is_favourited ? 'favourited' : 'favourite';

$recipe_likes = count($recipe->get_recipe_likes());
$recipe_favourites = count($recipe->get_recipe_favourites());

$html_tags = '';
foreach ($recipe->get_tags() as $tag) {
    $url_encoded_tag = urlencode($tag->tag_name);
    $html_tag_name = htmlspecialchars($tag->tag_name, ENT_QUOTES, 'UTF-8');

    $html_tags .= <<<HTML
        <a href="/?search=%23{$url_encoded_tag}" class="tag">#{$html_tag_name}</a>
    HTML;
}

?>
<section class="recipe-full">
    <h3 class="title"><?= $safe_title ?></h3>
    <div class="sub-heading">
        <a href="/user/<?= $recipe->user_id ?>" class="author"><?= $safe_author_name ?></a>
    </div>

    <div class="tags">
        <?= $html_tags ?>
    </div>

    <div class="info">
        <span class="time">
            <img src="/assets/time.svg" alt="minutes:">
            <?= (int) $recipe->total_time ?> mins
        </span>
        <span class="portions">
            <img src="/assets/knife-and-fork.svg" alt="serves:">
            <?= (int) $recipe->portions ?> portions
        </span>
    </div>

    <div class="footer">
        <button onclick="handleRecipeAction(this, '/like-recipe/<?= $recipe->recipe_id ?>', 'like')"
            class="like-button <?= $like_status ?>" data-status="<?= $like_status ?>" aria-label="Like">
            <img src="/assets/heart.svg" alt="Like">
            <span class="action-count"><?= $recipe_likes ?></span>
        </button>

        <button onclick="handleRecipeAction(this, '/favourite-recipe/<?= $recipe->recipe_id ?>', 'favourite')"
            class="favourite-button <?= $favourite_status ?>" data-status="<?= $favourite_status ?>"
            aria-label="Favourite">
            <img src="/assets/bookmark.svg" alt="Favourite">
            <span class="action-count"><?= $recipe_favourites ?></span>
        </button>

        <div class="basket-controls-context">
            <?php $basket_item = $user_id ? Basket::from_id($recipe->recipe_id, $user_id) : null; ?>

            <?php if (!$basket_item): ?>
                <button onclick="handleBasketAdd(this, '/add/<?= $recipe->recipe_id ?>')" class="add-button"
                    aria-label="Add to Basket">
                    Add To Basket
                </button>
            <?php else: ?>
                <?php $count = (int) $basket_item->amount; ?>

                <div class="basket-management-group" data-recipe-id="<?= $recipe->recipe_id ?>">
                    <a href="javascript:void(0)" onclick="handleBasketDecrement('<?= $recipe->recipe_id ?>')"
                        class="decrement-btn" aria-label="Decrease quantity">-</a>
                    <span class="recipe-count-display"><?= $count ?></span>
                    <a href="javascript:void(0)" onclick="handleBasketIncrement('<?= $recipe->recipe_id ?>')"
                        class="increment-btn" aria-label="Increase quantity">+</a>
                    <a href="javascript:void(0)" onclick="handleBasketRemove('<?= $recipe->recipe_id ?>')"
                        class="remove-btn" aria-label="Remove item">Remove</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <div class="recipe-ingredients">
        <h3>Ingredients</h3>
        <ul class="ingredient-list">
            <?php

            $sorted_ing = $recipe->get_ingredients_list();
            usort($sorted_ing, fn ($a, $b) => $a->get_ingredient()->category <=> $b->get_ingredient()->category);

            ?>
            <?php foreach ($sorted_ing as $ingredients_list): ?>
                <?php
                $ingredient = $ingredients_list->get_ingredient();
                $unit = $ingredients_list->get_unit();
                if (!$ingredient || !$unit) {
                    continue;
                }
                $safe_ing_name = htmlspecialchars($ingredient->name, ENT_QUOTES, 'UTF-8');
                $safe_unit_short = htmlspecialchars($unit->short_hand, ENT_QUOTES, 'UTF-8');
                $formatted_amount = (float) $ingredients_list->amount;
                ?>
                <li><?= $formatted_amount ?>     <?= $safe_unit_short ?>     <?= $safe_ing_name ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <hr>

    <div class="recipe-steps">
        <h3>Method Steps</h3>
        <ol class="step-list">
            <?php

            $sorted_steps = $recipe->get_steps();
            usort($sorted_steps, fn ($a, $b) => $a->step_number <=> $b->step_number);

            ?>
            <?php foreach ($sorted_steps as $step): ?>
                <?php
                $safe_step_text = htmlspecialchars($step->step, ENT_QUOTES, 'UTF-8');
                $step_number = (int) $step->step_number;
                $step_ingredients = $step->get_ingredients_used_in_steps();
                ?>
                <li class="step-item">
                    <p class="step-text"><strong>Step <?= $step_number ?>:</strong> <?= $safe_step_text ?></p>

                    <?php if (!empty($step_ingredients)): ?>
                        <div class="step-ingredients-context">
                            <span class="step-ingredients-label">Ingredients used in this step:</span>
                            <ul class="step-ingredients-list">
                                <?php foreach ($step_ingredients as $step_ing): ?>
                                    <?php
                                    $ingredient = $step_ing->get_ingredient();
                                    $unit = $step_ing->get_unit();
                                    if (!$ingredient || !$unit) {
                                        continue;
                                    }
                                    $safe_ing_name = htmlspecialchars($ingredient->name, ENT_QUOTES, 'UTF-8');
                                    $safe_unit_short = htmlspecialchars($unit->short_hand, ENT_QUOTES, 'UTF-8');
                                    $formatted_amount = (float) $step_ing->amount;
                                    ?>
                                    <li><?= $formatted_amount ?>             <?= $safe_unit_short ?>             <?= $safe_ing_name ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <hr>

    <div class="recipe-comments-section">
        <h3>Comments (<?= count($recipe->get_comments()) ?>)</h3>

        <?php if ($account): ?>
            <form action="/recipe/<?= $recipe->recipe_id ?>" method="POST" class="comment-form">
                <textarea name="comment_body" placeholder="Write a comment..." required></textarea>
                <button type="submit" class="profile-button">Post Comment</button>
            </form>
        <?php else: ?>
            <p class="login-notice"><a href="/login">Log in</a> to leave a comment or reply.</p>
        <?php endif; ?>

        <div class="comments-list">
            <?php
            $comments = $recipe->get_comments();
            usort($comments, fn ($a, $b) => strcmp($b->created_on, $a->created_on));
            foreach ($comments as $comment):
                $safe_body = htmlspecialchars($comment->body, ENT_QUOTES, 'UTF-8');
                $safe_username = htmlspecialchars($comment->get_user()->username, ENT_QUOTES, 'UTF-8');
                $comment_time = date('d M Y, H:i', strtotime($comment->created_on));
                $likes_count = count($comment->get_comment_likes());
                $has_liked = $account ? CommentLike::from_id($comment->comment_id, $account->user_id) !== null : false;
                $like_status = $has_liked ? 'liked' : 'like';
                ?>
                <div class="comment-item" id="comment-<?= $comment->comment_id ?>">
                    <div class="comment-header">
                        <strong><?= $safe_username ?></strong>
                        <span class="comment-date"><?= $comment_time ?></span>
                    </div>
                    <p class="comment-body"><?= $safe_body ?></p>
                    <div class="comment-footer">
                        <button onclick="handleCommentLike(this, '<?= $comment->comment_id ?>')"
                            class="comment-like-btn <?= $like_status ?>" data-status="<?= $like_status ?>">
                            ♥ <span class="like-count"><?= $likes_count ?></span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>