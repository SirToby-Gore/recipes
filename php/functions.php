<?php

require_once __DIR__ . '/init.php';

function random_string(int $length): string {
    return bin2hex(string: random_bytes(length: $length / 2));
}

function create_recipe_div(Recipe $recipe): HtmlTag {
    $recipe_div = new Div();
    $recipe_div->class = "recipe";
    $recipe_div->on_click = "window.location.href = './?recipe={$recipe->id}'";
    
    $i = 0;
    $recipe_div->children[] = new Heading2();
    $recipe_div->children[$i]->inner_text = $recipe->title;
    $recipe_div->children[$i]->class = "title";

    $i++;
    $recipe_div->children[] = new Anchor();
    $recipe_div->children[$i]->href = "./?user={$recipe->user_id}";
    $recipe_div->children[$i]->inner_text = User::from_id($recipe->user_id)->name;

    $i++;
    $recipe_div->children[] = new Paragraph();
    $recipe_div->children[$i]->inner_text = $recipe->description;

    $i++;
    $recipe_div->children[] = new Paragraph();
    $recipe_div->children[$i]->class = "details";

    $j = 0;
    $recipe_div->children[$i]->children[] = new Span();
    $recipe_div->children[$i]->children[$j]->inner_text = file_get_contents(__DIR__ . '/../assets/images/knife-and-fork.svg') . $recipe->portions;
    $recipe_div->children[$i]->children[$j]->class = "portions";
    
    $j++;
    $recipe_div->children[$i]->children[] = new Span();
    $recipe_div->children[$i]->children[$j]->inner_text = file_get_contents(__DIR__ . '/../assets/images/time.svg') . $recipe->total_time_minutes;
    $recipe_div->children[$i]->children[$j]->class = "time";

    $j++;
    $recipe_div->children[$i]->children[] = new Span();
    $recipe_div->children[$i]->children[$j]->inner_text = file_get_contents(__DIR__ . '/../assets/images/book.svg') . $recipe->number_of_steps;
    $recipe_div->children[$i]->children[$j]->class = "steps";

    return $recipe_div;
}

function create_user_div(User $user): HtmlTag {
    $user_div = new Div();
    $user_div->class = "user";
    // FIX: Corrected typo from 'windows.location.href' to 'window.location.href'
    $user_div->on_click = "window.location.href = './?user={$user->id}'";

    $i = 0;
    $user_div->children[] = new Heading3();
    $user_div->children[$i]->class = "name";
    $user_div->children[$i]->inner_text = $user->name;

    $i++;
    $user_div->children[] = new Anchor();
    $user_div->children[$i]->href = "./?user={$user->id}";
    $user_div->children[$i]->inner_text = "go to user's page";

    return $user_div;
}

function create_comment_div(Comment $comment): HtmlTag {
    $comment_user = User::from_id($comment->user_id);
    
    $comment_div = new Div();
    $comment_div->class = "comment";

    $i = 0;
    $comment_div->children[] = new Anchor();
    // FIX: Changed href to properly link to the user's page
    $comment_div->children[$i]->href = "./?user={$comment_user->id}"; 
    $comment_div->children[$i]->inner_text = $comment_user->name;

    $i++;
    $comment_div->children[] = new Div();
    $comment_div->children[$i]->class = "date";
    $comment_div->children[$i]->inner_text = $comment->last_edited == null ? $comment->created_on : $comment->created_on . " edited: " . $comment->last_edited;
    // Removed redundant line $comment_div->children[$i];
    
    $i++;
    $comment_div->children[] = new Div();
    $comment_div->children[$i]->class = "likes";
    $comment_div->children[$i]->inner_text = file_get_contents(__DIR__ . '/../assets/images/heart.svg') . $comment->likes;

    $i++;
    $comment_div->children[] = new Paragraph();
    $comment_div->children[$i]->class = "body";
    $comment_div->children[$i]->inner_text = $comment->body;

    return $comment_div;
}
