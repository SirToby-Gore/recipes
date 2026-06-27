<?php

require_once __DIR__ . '/_functions.php';

function render_recipe_card(Recipe $recipe): string
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
    $recipe_favourites = count(Recipe::from_id($recipe->recipe_id)->get_recipe_favourites());

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

function render_user_card(User $user): string
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

function render_form_input(
    string $id,
    string $label,
    string $type,
    string $value,
    string $placeholder = '',
    bool $required = false,
    string $hint = ''
): string {
    $escaped_id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $escaped_label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $escaped_type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
    $escaped_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    $escaped_placeholder = htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8');
    $required_attribute = $required ? 'required' : '';

    $hint_markup = '';
    if ($hint !== '') {
        $escaped_hint = htmlspecialchars($hint, ENT_QUOTES, 'UTF-8');
        $hint_markup = "\n        <small class=\"form-hint\">{$escaped_hint}</small>";
    }

    return <<<HTML
    <div class="form-group">
        <label for="{$escaped_id}">{$escaped_label}</label>
        <input 
            type="{$escaped_type}" 
            id="{$escaped_id}" 
            value="{$escaped_value}" 
            placeholder="{$escaped_placeholder}"
            {$required_attribute}
        >{$hint_markup}
    </div>
    HTML;
}

function render_form_textarea(
    string $id,
    string $label,
    string $value,
    string $placeholder = '',
    bool $required = false
): string {
    $escaped_id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $escaped_label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $escaped_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    $escaped_placeholder = htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8');
    $required_attribute = $required ? 'required' : '';

    return <<<HTML
    <div class="form-group">
        <label for="{$escaped_id}">{$escaped_label}</label>
        <textarea 
            id="{$escaped_id}" 
            placeholder="{$escaped_placeholder}"
            {$required_attribute}
        >{$escaped_value}</textarea>
    </div>
    HTML;
}

function render_form_number_input(
    string $id,
    string $label,
    string $value,
    int $min = 1,
    bool $required = false
): string {
    $escaped_id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $escaped_label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $escaped_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    $required_attr = $required ? 'required' : '';

    return <<<HTML
    <div class="form-group">
        <label for="{$escaped_id}">{$escaped_label}</label>
        <input 
            type="number" 
            id="{$escaped_id}" 
            value="{$escaped_value}" 
            min="{$min}" 
            {$required_attr}
        >
    </div>
    HTML;
}

function render_form_divider(): string
{
    return <<<HTML
    <hr class="form-divider">
    HTML;
}

function render_form_section_header(string $title, string $description): string
{
    $escaped_title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $escaped_desc = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    return <<<HTML
    <div class="form-section-header">
        <h3>{$escaped_title}</h3>
        <p class="section-description">{$escaped_desc}</p>
    </div>
    HTML;
}

function render_form_actions(bool $is_edit_mode, string $recipe_id): string
{
    $escaped_id = htmlspecialchars($recipe_id, ENT_QUOTES, 'UTF-8');
    $cancel_href = $is_edit_mode ? "/recipe/{$escaped_id}" : "/";
    $submit_text = $is_edit_mode ? "Save Changes" : "Publish Recipe";

    return <<<HTML
    <div class="form-actions-primary">
        <a href="{$cancel_href}" class="cancel-btn">Cancel</a>
        <button type="submit" class="submit-btn">{$submit_text}</button>
    </div>
    HTML;
}

function format_number(float|int $number): string
{
    $int = floor($number);
    $remainder = $number - $int;

    $frac_str = '';

    if ($remainder < 0.0625) {
        $frac_str = '';
    } elseif ($remainder < 0.1875) {
        $frac_str = '<sup>1</sup>/<sub>8</sub>'; // 1/8
    } elseif ($remainder < 0.29) {
        $frac_str = '<sup>1</sup>/<sub>4</sub>'; // 1/4
    } elseif ($remainder < 0.35) {
        $frac_str = '<sup>1</sup>/<sub>3</sub>'; // 1/3
    } elseif ($remainder < 0.4375) {
        $frac_str = '<sup>3</sup>/<sub>8</sub>'; // 3/8
    } elseif ($remainder < 0.5625) {
        $frac_str = '<sup>1</sup>/<sub>2</sub>'; // 1/2
    } elseif ($remainder < 0.64) {
        $frac_str = '<sup>5</sup>/<sub>8</sub>'; // 5/8
    } elseif ($remainder < 0.71) {
        $frac_str = '<sup>2</sup>/<sub>3</sub>'; // 2/3
    } elseif ($remainder < 0.8125) {
        $frac_str = '<sup>3</sup>/<sub>4</sub>'; // 3/4
    } elseif ($remainder < 0.9375) {
        $frac_str = '<sup>7</sup>/<sub>8</sub>'; // 7/8
    } else {
        $int += 1;
        $frac_str = '';
    }

    if (0 === $int && $frac_str !== '') {
        return $frac_str;
    }

    return "{$int} {$frac_str}";
}