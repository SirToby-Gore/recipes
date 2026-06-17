<?php

require_once __DIR__ . '/_functions.php';

function recipe_card(Recipe $recipe): string
{
    $current_user = get_account() ?? Blank::$user;
    $user_id = (isset($current_user->user_id) && $current_user->user_id) ? $current_user->user_id : null;

    $safe_title = htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8');
    $safe_author_name = htmlspecialchars($recipe->get_user()->username, ENT_QUOTES, 'UTF-8');

    $is_liked = $user_id ? has_user_liked_recipe($recipe) : false;
    $is_favourited = $user_id ? has_user_favourited_recipe($recipe) : false;

    $like_status = $is_liked ? 'liked' : 'like';
    $favourite_status = $is_favourited ? 'favourited' : 'favourite';

    $recipe_likes = count(Recipe::from_id($recipe->recipe_id)->get_like_count());
    $recipe_favourites = count(Recipe::from_id($recipe->recipe_id)->get_like_count());

    $html_tags = '';
    foreach ($recipe->get_tags() as $tag) {
        $url_encoded_tag = urlencode($tag->tag_name);
        $html_tag_name = htmlspecialchars($tag->tag_name, ENT_QUOTES, 'UTF-8');

        $html_tags .= <<<HTML
            <a href="/?search=%23{$url_encoded_tag}" class="tag">#{$html_tag_name}</a>
        HTML;
    }

    $html = <<<HTML
        <div class="recipe-card" id="recipe-card-{$recipe->recipe_id}">
            <div class="heading">
                <a href="/recipe/{$recipe->recipe_id}" class="title">{$safe_title}</a>
            </div>
            <div class="sub-heading">
                <a href="/user/{$recipe->user_id}" class="author">{$safe_author_name}</a>
            </div>
            <div class="info">
                <span class="time"><img src="/assets/time.svg" alt="minutes:">{$recipe->total_time}</span>
                <span class="portions"><img src="/assets/knife-and-fork.svg" alt="serves:">{$recipe->portions}</span>
            </div>
            <div class="tags">
                {$html_tags}
            </div>
            <div class="footer">
                <button 
                    onclick="handleRecipeAction(this, '/recipe/like/{$recipe->recipe_id}', 'like')" 
                    class="like-button {$like_status}"
                    data-status="{$like_status}"
                    aria-label="Like">
                    <img src="/assets/heart.svg" alt="Like">
                    <span class="action-count">{$recipe_likes}</span>
                </button>

                <button 
                    onclick="handleRecipeAction(this, '/recipe/favourite/{$recipe->recipe_id}', 'favourite')" 
                    class="favourite-button {$favourite_status}"
                    data-status="{$favourite_status}"
                    aria-label="Favourite">
                    <img src="/assets/bookmark.svg" alt="Favourite">
                    <span class="action-count">{$recipe_favourites}</span>
                </button>

                <div class="basket-controls-context">
    HTML;

    // Single Source of Truth: Look up real basket records out of the Baskets DB table
    $basket_item = $user_id ? Basket::from_id($recipe->recipe_id, $user_id) : null;

    if (!$basket_item) {
        $html .= <<<HTML
            <button 
                onclick="handleBasketAdd('{$recipe->recipe_id}', this)" 
                class="add-button"
                aria-label="Add to Basket">
                Add To Basket
            </button>
        HTML;
    } else {
        $count = (int) $basket_item->amount;

        $html .= <<<HTML
            <div class="basket-management-group" data-recipe-id="{$recipe->recipe_id}">
                <a href="javascript:void(0)" onclick="handleBasketDecrement('{$recipe->recipe_id}')" class="decrement-btn" aria-label="Decrease quantity">-</a>
                <span class="recipe-count-display">{$count}</span>
                <a href="javascript:void(0)" onclick="handleBasketIncrement('{$recipe->recipe_id}')" class="increment-btn" aria-label="Increase quantity">+</a>
                <a href="javascript:void(0)" onclick="handleBasketRemove('{$recipe->recipe_id}')" class="remove-btn" aria-label="Remove item">Remove</a>
            </div>
        HTML;
    }

    $html .= <<<HTML
            </div>
                <a href="/recipe/{$recipe->recipe_id}" class="profile-button" aria-label="View Recipe">
                    <img src="/assets/book.svg" alt="View Recipe">
                </a>
            </div>
        </div>
    HTML;

    return $html;
}

function user_card(User $user): string
{
    $safe_name = htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8');

    $html = <<<HTML
        <div class="user-card">
            <div class="heading">
                <a href="/user/{$user->user_id}" class="title">{$safe_name}</a>
            </div>
            <div class="footer">
                <a href="/user/{$user->user_id}" class="profile-button">View Profile</a>
            </div>
        </div>
    HTML;

    return $html;
}