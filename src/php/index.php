<?php

require_once __DIR__ . '/init.php';

// A simple utility to get a unit ID from its shorthand (e.g., 'g' -> 1)
// This should exist in the Unit class for a real app.
function get_unit_id_from_shorthand(string $shorthand): int {
    // Placeholder logic - In a real app, this would query the Units table.
    return 1; 
}

// A simple utility to find an ingredient by name or create it if it doesn't exist
// This should exist in the Ingredient class.
function find_or_create_ingredient(string $name): string {
    // Placeholder logic - In a real app, this would query/insert into Ingredients.
    // Returns a dummy ID for now.
    return hash('sha256', $name);
}

function main(): void {
    global $connection, $account, $random_recipes;
    
    // --- Existing Login POST Handler ---
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];
        
        $stmt = $connection->prepare("SELECT `id` FROM `Users` WHERE `email`=?");
        $stmt->bind_param('s', $user_email);
        $stmt->execute();
        $user_id = ($stmt->get_result()->fetch_assoc() ?? ['id' => ''])['id'];
    
        if (User::is_id_in_use($user_id)) {
            $user = User::from_id($user_id);
    
            if (
                User::is_email_taken($user_email)
             && $user->is_password_correct($user_password)
            ) {
                $token = new Token(
                    Token::get_new_token(),
                    $user->id,
                    '',
                );
    
                $token->create();
        
                $_SESSION['token'] = $token->token;
        
                header('Location: ./');
                return;
            } 
        }
    }

    // --- CRUD ACTION HANDLERS ---

    // 1. User Signup Handler (POST) - Create Account
    if (isset($_GET['signup']) && $_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])) {
        try {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                throw new Exception("Passwords do not match.");
            }
            if (User::is_email_taken($email)) {
                throw new Exception("Email is already registered.");
            }
            
            // --- Placeholder for User Creation Logic ---
            $user_id = User::get_new_id();
            $salt = User::get_new_salt();
            $password_hash = hash('sha256', $password . $salt);
            $new_user = new User($user_id, $name, $email, $password_hash, $salt, date('Y-m-d H:i:s'));
            $new_user->create();
            // --- End Placeholder ---

            header("Location: ./?login&success=" . urlencode("Account created! Please log in."));
            return;
        } catch (Exception $e) {
            header("Location: ./?signup&error=" . urlencode($e->getMessage()));
            return;
        }
    }
    
    // 2. User Update Handler (POST) - Update Account
    if (isset($_GET['account']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account_details'])) {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to update your account.");
            }
            
            $user = $account->user;
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($name) || empty($email)) {
                throw new Exception("Name and Email are required.");
            }
            
            if (!empty($password)) {
                if ($password !== $confirm_password) {
                    throw new Exception("New passwords do not match.");
                }
                $user->salt = User::get_new_salt();
                $user->password_hash = hash('sha256', $password . $user->salt);
            }
            
            $user->name = $name;
            $user->email = $email;
            // $user->update(); // Assumes a User::update() method exists
            
            header("Location: ./?account&success=" . urlencode("Account updated successfully."));
            return;
        } catch (Exception $e) {
            header("Location: ./?account&error=" . urlencode($e->getMessage()));
            return;
        }
    }

    // 3. User Delete Handler (GET) - Delete Account
    if (isset($_GET['delete_account_confirm'])) {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to delete your account.");
            }
            
            $user = $account->user;
            
            // IMPORTANT: Log user out first.
            $_SESSION['token'] = null;
            $account->token->delete(); // Delete current token
            // $user->delete(); // Assumes User::delete() method exists and cascades to recipes/comments/tokens
            
            header("Location: ./?success=" . urlencode("Your account has been permanently deleted."));
            return;
        } catch (Exception $e) {
            header("Location: ./?account&error=" . urlencode($e->getMessage()));
            return;
        }
    }

    // 4. Recipe Creation Handler (POST)
    if (isset($_GET['create_recipe']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to create a recipe.");
            }
            
            // Validation
            if (empty($_POST['title']) || empty($_POST['portions']) || empty($_POST['time'])) {
                throw new Exception("Title, portions, and time are required.");
            }
            
            // --- Placeholder for Recipe Creation Logic ---
            $new_recipe_id = Recipe::get_new_id();
            // In a real app, this would loop through ingredients, steps, and tags
            // and call Ingredient_list::create(), Step::create(), and Tag::create().
            // $new_recipe = new Recipe($new_recipe_id, $_POST['title'], ..., $account->user->id);
            // $new_recipe->create(); 
            // --- End Placeholder ---

            header("Location: ./?recipe=" . urlencode($new_recipe_id) . "&success=" . urlencode("Recipe created successfully!"));
            return;
        } catch (Exception $e) {
            header("Location: ./?create_recipe&error=" . urlencode($e->getMessage()));
            return;
        }
    }

    // 5. Recipe Update Handler (POST)
    if (isset($_GET['recipe']) && isset($_GET['edit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to update a recipe.");
            }
            $recipe = Recipe::from_id($_GET['recipe']);
            
            if ($account->user->id !== $recipe->user_id) {
                throw new Exception("You do not own this recipe.");
            }

            // Validation
            if (empty($_POST['title']) || empty($_POST['portions']) || empty($_POST['time'])) {
                throw new Exception("Title, portions, and time are required.");
            }
            
            // --- Placeholder for Recipe Update Logic ---
            $recipe->title = $_POST['title'];
            $recipe->description = $_POST['description'];
            $recipe->portions = (int)$_POST['portions'];
            $recipe->total_time_minutes = (int)$_POST['time'];
            $recipe->number_of_steps = (int)$_POST['steps'];
            // $recipe->update(); // Assumes Recipe::update() exists and handles sub-entities update/deletion/creation
            // --- End Placeholder ---

            header("Location: ./?recipe=" . urlencode($recipe->id) . "&success=" . urlencode("Recipe updated successfully."));
            return;
        } catch (Exception $e) {
            header("Location: ./?recipe=" . urlencode($_GET['recipe']) . "&edit=1&error=" . urlencode($e->getMessage()));
            return;
        }
    }
    
    // 6. Recipe Deletion Handler (GET)
    if (isset($_GET['delete_recipe'])) {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to delete a recipe.");
            }
            $recipe = Recipe::from_id($_GET['delete_recipe']);
            
            if ($account->user->id !== $recipe->user_id) {
                throw new Exception("You do not own this recipe.");
            }
            
            // $recipe->delete(); // Assumes Recipe::delete() exists and handles cascade for ingredients/steps/comments/tags
            
            header("Location: ./?success=" . urlencode("Recipe deleted successfully."));
            return;
        } catch (Exception $e) {
            header("Location: ./?recipe=" . urlencode($_GET['delete_recipe']) . "&error=" . urlencode($e->getMessage()));
            return;
        }
    }

    // 7. Comment Creation Handler (POST)
    if (isset($_GET['recipe']) && isset($_POST['comment_body'])) {
        try {
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to post a comment.");
            }
            $recipe_id = $_GET['recipe'];
            $body = trim($_POST['comment_body']);

            if (empty($body)) {
                 throw new Exception("Comment body cannot be empty.");
            }
            
            // --- Placeholder for Comment Creation Logic ---
            // $comment = new Comment(Comment::get_new_id(), $recipe_id, $account->user->id, $body, 0, date('Y-m-d H:i:s'), null);
            // $comment->create();
            // --- End Placeholder ---
            
            header("Location: ./?recipe=" . urlencode($recipe_id));
            return;
        } catch (Exception $e) {
            header("Location: ./?recipe=" . urlencode($_GET['recipe']) . "&error=" . urlencode($e->getMessage()));
            return;
        }
    }
    
    // 8. Comment Deletion Handler (GET)
    if (isset($_GET['delete_comment'])) {
        try {
            $comment_id = $_GET['delete_comment'];
            $comment = Comment::from_id($comment_id);
            $recipe_id = $comment->recipe_id;
            
            if (!$account->logged_in) {
                throw new Exception("You must be logged in to delete a comment.");
            }
            
            $recipe = Recipe::from_id($recipe_id);
            
            // Check ownership: comment owner OR recipe owner
            if ($account->user->id !== $comment->user_id && $account->user->id !== $recipe->user_id) {
                throw new Exception("You do not own this comment or the recipe.");
            }
            
            // $comment->delete(); // Assumes Comment::delete() method exists
            
            header("Location: ./?recipe=" . urlencode($recipe_id));
            return;
        } catch (Exception $e) {
            header("Location: ./?recipe=" . urlencode($comment->recipe_id ?? '') . "&error=" . urlencode($e->getMessage()));
            return;
        }
    }

    // --- Existing Redirects and Setup ---
    
    // Authorization check for recipe edit form display
    if (isset($_GET['recipe']) && isset($_GET['edit'])) {
        $recipe_id = $_GET['recipe'];
        if (Recipe::is_id_in_use($recipe_id)) {
            $recipe = Recipe::from_id($recipe_id);
            if (!$account->logged_in || $account->user->id != $recipe->user_id) {
                $error = urlencode("You do not have permission to edit this recipe.");
                header("Location: ./?recipe=" . urlencode($recipe_id) . "&error=$error");
                return;
            }
        }
    }

    if (isset($_GET['search']) && empty($_GET['search'] ?? '')) {
        header('Location: ./');
        return;
    }
    
    // ... existing random recipe fetch ...
    
    $stmt = $connection->prepare("SELECT `id` FROM `Recipes` ORDER BY rand() LIMIT 20");
    $stmt->execute();

    foreach ($stmt->get_result()->fetch_all() as $recipe_id) {
        $random_recipes[] = Recipe::from_id($recipe_id[0]);
    }
    
    $stmt->close();
}

$random_recipes = [];

main();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe App</title>
    <style>
        <?= file_get_contents('../css/styles.css'); ?>
    </style>
</head>
<body>

<nav class="nav-bar">
    <a href="./" class="home">
        <?= file_get_contents(__DIR__ . '/../assets/images/home.svg') ?>
    </a>
    <form method="get" action="./" class="search-form">
        <input type="text" class="search-input" placeholder="<?= $random_recipes[0]->title ?? 'Search recipes...' ?>" name="search" value="<?= $_GET['search'] ?? '' ?>">
        <button type="submit" class="search-button">
            <?= file_get_contents(__DIR__ . '/../assets/images/search.svg') ?>
        </button>
    </form>
    <div class="nav-account-links">
        <?php if ($account->logged_in): ?>
             <a href="./?create_recipe" class="create-recipe-link">
                <?= file_get_contents(__DIR__ . '/../assets/images/add.svg') ?>
            </a>
        <?php endif ?>
        <a href="./?<?= $account->logged_in ? 'account' : 'login' ?>" class="account">
            <?= file_get_contents(__DIR__ . '/../assets/images/account.svg') ?>
        </a>
    </div>
</nav>

<main>

<?php if (isset($_GET['error'])): ?>
    <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif ?>
<?php if (isset($_GET['success'])): ?>
    <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif ?>
<?php if(isset($_GET['debug'])): ?>
    <p class="info">debug has been set</p>
<?php endif ?> 
<?php if (isset($_GET['search'])): ?>
    <?php
    
    // ... existing search logic ...

    $tags = $_GET['search'];
    $recipe_ids = [];

    foreach (explode(' ', $tags) as $tag) {
        // Search by Tag
        $stmt = $connection->prepare('SELECT `recipe_id` FROM `Tags` WHERE `tag_name` LIKE ?');
        $like_tag = "%$tag%";
        $stmt->bind_param('s', $like_tag);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all();
        foreach ($results as $row) {
             $recipe_id = $row[0];
             if (in_array($recipe_id, array_keys($recipe_ids))) {
                 $recipe_ids[$recipe_id]++;
             } else {
                 $recipe_ids[$recipe_id] = 1;
             }
        }
    }

    foreach (explode(' ', $tags) as $tag) {
        // Search by Recipe Title
        $stmt = $connection->prepare("SELECT `id` FROM `Recipes` WHERE `title` LIKE ?");
        $like_tag = "%$tag%";
        $stmt->bind_param('s', $like_tag);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all();
        foreach ($results as $row) {
             $recipe_id = $row[0];
             if (in_array($recipe_id, array_keys($recipe_ids))) {
                 $recipe_ids[$recipe_id]++;
             } else {
                 $recipe_ids[$recipe_id] = 1;
             }
        }
    }

    asort($recipe_ids, SORT_ASC);
    $recipe_ids = array_reverse($recipe_ids);

    $stmt = $connection->prepare("SELECT `id` FROM `Users` WHERE `name` LIKE ?");
    $like_name = "%{$tags}%";
    $stmt->bind_param('s', $like_name);
    $stmt->execute();
    $user_ids = $stmt->get_result()->fetch_all();

    ?>

    <?php if (count($recipe_ids) > 0): ?>
        <h1>Recipes</h1>
        <div class="recipes">
            <?php foreach ($recipe_ids as $recipe_id => $count): ?>
                <?= create_recipe_div(Recipe::from_id($recipe_id))->render() ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (count($user_ids) > 0): ?>
        <h1>Users</h1>
        <div class="users">
            <?php foreach ($user_ids as $row): ?>
                <?= create_user_div(User::from_id($row[0]))->render(); ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (count($user_ids) == 0 && count($recipe_ids) == 0): ?>
        <p class="warning">Sorry could not find any users or recipes that match <?= htmlspecialchars($tags) ?></p>
    <?php endif ?>


<?php elseif (isset($_GET['create_recipe'])): ?>
    <?php if (!$account->logged_in): ?>
        <p class="error">You must be logged in to create a recipe. <a href="./?login">Log in here.</a></p>
    <?php else: ?>
        <h1>Create New Recipe</h1>
        <form action="./?create_recipe" method="post" class="recipe-form">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="My Awesome Recipe" required>

            <label for="description">Description</label>
            <textarea name="description" placeholder="A short description of the dish..."></textarea>

            <label for="portions">Portions</label>
            <input type="number" name="portions" placeholder="4" required min="1">

            <label for="time">Total Time (minutes)</label>
            <input type="number" name="time" placeholder="30" required min="1">
            
            <!-- Simplified ingredients/steps input for demonstration. In a real app, this would use JS for dynamic fields. -->
            <h3>Ingredients (Example)</h3>
            <p class="foot-note">Please enter ingredient in the format: amount, unit, name (e.g., 200, g, flour)</p>
            <textarea name="ingredients" rows="5" placeholder="200, g, chicken breast&#10;1, tbsp, olive oil"></textarea>

            <h3>Steps (Example)</h3>
            <p class="foot-note">Enter each step on a new line.</p>
            <textarea name="steps" rows="5" placeholder="1. Preheat the oven.&#10;2. Mix all ingredients."></textarea>
            
            <input type="submit" value="Create Recipe">
        </form>
    <?php endif ?>

<?php elseif (isset($_GET['recipe'])): ?>
    <?php

    $recipe_id = $_GET['recipe'];
    $recipe = Recipe::from_id($recipe_id);
    $recipe_owner = User::from_id($recipe->user_id);
    $is_owner = $account->logged_in && $account->user->id == $recipe->user_id;

    ?>

    <?php if (isset($_GET['edit'])): ?>
    
    <h1>Edit Recipe: <?= htmlspecialchars($recipe->title) ?></h1>
    <form action="./?recipe=<?= urlencode($recipe->id) ?>&edit=1" method="post" class="recipe-form">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="my awesome recipe" value="<?= htmlspecialchars($recipe->title) ?>" required>

        <label for="description">Description</label>
        <textarea name="description" placeholder="this is the bit of the recipe no-one will read"><?= htmlspecialchars($recipe->description) ?></textarea>

        <label for="portions">Portions</label>
        <input type="number" name="portions" placeholder="4" value="<?= $recipe->portions ?>" required min="1">

        <label for="time">Total Time (minutes)</label>
        <input type="number" name="time" placeholder="30" value="<?= $recipe->total_time_minutes ?>" required min="1">

        <label for="steps">Number of Steps (For info only)</label>
        <input type="number" name="steps" placeholder="6" value="<?= $recipe->number_of_steps ?>" min="1">
        
        <!-- Simplified for demonstration: The actual ingredient and step updating logic is complex -->
        <h3>Ingredients (Update the Recipe Class logic to handle these)</h3>
        <p class="foot-note">Ingredients are currently read-only in this form. A fully functional update would require dynamic fields.</p>
        <ol>
        <?php foreach ($recipe->get_ingredients() as $index => $ingredient): 
            $ing = Ingredient::from_id($ingredient->ingredient_id);
            $unit = Unit::from_id($ingredient->unit_id);
        ?>
            <li><?= "{$ingredient->amount} {$unit->short_hand} of {$ing->name}" ?></li>
        <?php endforeach ?>
        </ol>

        <input type="submit" value="Update Recipe">
        <a href="./?delete_recipe=<?= urlencode($recipe->id) ?>" class="button delete-button" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete Recipe</a>
    </form>
        
    <?php else: ?>
    
    <div class="recipe full-screen">
        <h1 class="title"><?= htmlspecialchars($recipe->title) ?></h1>
        <a href="./?user=<?= $recipe->user_id ?>" class="user"><?= htmlspecialchars($recipe_owner->name) ?></a>
        
        <?php if ($is_owner): ?>
            <div class="recipe-actions">
                <a href="./?recipe=<?= urlencode($recipe->id) ?>&edit=1">edit</a>
                <a href="./?delete_recipe=<?= urlencode($recipe->id) ?>" onclick="return confirm('Are you sure you want to delete this recipe?')" style="color: red;">delete</a>
            </div>
        <?php endif ?>

        <div class="details">
            <span class="portions">
                <?= file_get_contents(__DIR__ . '/../assets/images/knife-and-fork.svg') . $recipe->portions ?>
            </span>
            <span class="time">
                <?= file_get_contents(__DIR__ . '/../assets/images/time.svg') . $recipe->total_time_minutes ?>
            </span>
            <span class="steps">
                <?= file_get_contents(__DIR__ . '/../assets/images/book.svg') . $recipe->number_of_steps ?>
            </span>
        </div>

        <?php if (!empty($recipe->description)): ?>
            <h3 class="title">Description</h3>
            <p class="description"><?= nl2br(htmlspecialchars($recipe->description)) ?></p>
        <?php endif ?>

        <h3 class="title">Ingredients</h3>
        <ol class="ingredients">
            <?php foreach ($recipe->get_ingredients() as $ingredient): ?>
                <li>
                    <span class="ingredient"><?= htmlspecialchars(Ingredient::from_id($ingredient->ingredient_id)->name) ?></span>
                    <span class="amount"><?= $ingredient->amount ?></span>
                    <span class="unit"><?= htmlspecialchars(Unit::from_id($ingredient->unit_id)->short_hand) ?></span>
                </li>
            <?php endforeach ?>
        </ol>

        <h3 class="title">Steps</h3>
        <ol class="steps">
            <?php foreach ($recipe->get_steps() as $step): ?>
                <li>
                    <?= nl2br(htmlspecialchars($step->step)) ?>
                </li>
            <?php endforeach ?>
        </ol>

        <div class="comments">
            <h3 class="title">Comments</h3>
        <?php if (count($recipe->get_comments()) > 0): ?>
            <?php foreach ($recipe->get_comments() as $comment): 
                $comment_owner = User::from_id($comment->user_id);
                $can_delete = $account->logged_in && ($account->user->id == $comment->user_id || $is_owner);
            ?>
                <div class="comment">
                    <p class="comment-body"><?= htmlspecialchars($comment->body) ?></p>
                    <div class="comment-footer">
                        <span class="comment-user">by <a href="./?user=<?= $comment->user_id ?>"><?= htmlspecialchars($comment_owner->name) ?></a></span>
                        <span class="comment-date">on <?= date('Y-m-d', strtotime($comment->created_on)) ?></span>
                        <?php if ($can_delete): ?>
                            <a href="./?delete_comment=<?= urlencode($comment->id) ?>" onclick="return confirm('Delete this comment?')" style="color: red; margin-left: 10px;">(delete)</a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p class="foot-note">Be the first to talk about this post.</p>    
        <?php endif ?>
        
            <?php if ($account->logged_in): ?>
                <form action="./?recipe=<?= urlencode($recipe->id) ?>" method="post" class="comment-form">
                    <textarea name="comment_body" placeholder="Add a comment..." required></textarea>
                    <input type="submit" value="Post Comment">
                </form>
            <?php else: ?>
                <p class="foot-note"><a href="./?login">Log in</a> to post a comment.</p>
            <?php endif ?>
        </div>
    </div>

    <?php endif ?>

<?php elseif (isset($_GET['ingredient'])): ?>
    <?php

    $ingredient_id = $_GET['ingredient'];
    $ingredient = Ingredient::from_id($ingredient_id);

    // var_dump($ingredient); // Kept the original debug for the user
    echo "<h1>Ingredient: " . htmlspecialchars($ingredient->name) . "</h1>";
    echo "<p>" . htmlspecialchars($ingredient->description) . "</p>";

    ?>

<?php elseif (isset($_GET['user'])): ?>
    <?php

    $user_id = $_GET['user'];
    $user = User::from_id($user_id);

    ?>

    <h1 class="title"><?= htmlspecialchars($user->name) ?></h1>

    <div class="recipes" style="display: flex; flex-direction: column; gap: 1rem">
        <?php foreach ($user->get_recipes() as $recipe): ?>
            <?= create_recipe_div($recipe)->render() ?>
        <?php endforeach ?>
    </div>

<?php elseif (isset($_GET['account'])): ?>
    <?php

    if (!$account->logged_in) {
        $error = urlencode("Please log in to see your account page");
        header("Location: ./?login&error=$error");
        return;
    }

    $user = $account->user;

    ?>

    <h1>My Account</h1>
    <a href="./?logout">Log Out</a>
    
    <h2>Update Details</h2>
    <form action="./?account" method="post" class="account-update-form">
        <input type="hidden" name="update_account_details" value="1">
        
        <label for="name">Name:</label>
        <input name="name" type="text" placeholder="Your Name" value="<?= htmlspecialchars($user->name) ?>" required>

        <label for="email">Email:</label>
        <input name="email" type="email" placeholder="example@email.com" value="<?= htmlspecialchars($user->email) ?>" required>

        <h3>Change Password (optional)</h3>
        <p class="foot-note">Leave blank if you don't want to change your password.</p>
        
        <label for="password">New Password</label>
        <input name="password" type="password" placeholder="New Password">

        <label for="confirm_password">Confirm New Password</label>
        <input name="confirm_password" type="password" placeholder="Confirm New Password">

        <input type="submit" value="Update Account">
    </form>
    
    <h2>Danger Zone</h2>
    <p>Permanently delete your account. This action cannot be undone and all your recipes will be lost.</p>
    <a href="./?delete_account_confirm=1" class="button delete-button" onclick="return confirm('Are you ABSOLUTELY sure you want to delete your account? This is irreversible.')">Delete Account</a>


<?php elseif (isset($_GET['login'])): ?>
    <?php

    $user_email = $_POST['email'] ?? '';
    $user_password = $_POST['password'] ?? '';

    $stmt = $connection->prepare("SELECT `id` FROM `Users` WHERE `email`=?");
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $user_id = ($stmt->get_result()->fetch_assoc() ?? ['id' => ''])['id'];

    $user = User::get_blank(); 
    
    if (User::is_id_in_use($user_id)) {
        $user = User::from_id($user_id);
    } 

    ?>
    <?php if (isset($_POST['email']) && isset($_POST['password'])): ?>
        <?php if (!User::is_email_taken($_POST['email'])): ?>
            <p class="error">Email is not found</p>
        <?php elseif (!$user->is_password_correct($user_password)): ?>
            <p class="error">Password is incorrect</p>
        <?php endif ?>
    <?php endif ?>

    <h1>Login</h1>
    <form action="./?login" method="post">
        <label for="email">Email:</label>
        <input name="email" type="email" placeholder="example@email.com" value="<?= htmlspecialchars($user_email) ?>" required>

        <label for="password">Password</label>
        <input name="password" type="password" placeholder="password" required>

        <input type="submit" value="Login">
    </form>
    <p class="foot-note">Don't have an account? <a href="./?signup">Sign up here.</a></p>

<?php elseif (isset($_GET['signup'])): ?>
    <h1>Sign Up</h1>
    <form action="./?signup" method="post">
        <label for="name">Name:</label>
        <input name="name" type="text" placeholder="Your Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        
        <label for="email">Email:</label>
        <input name="email" type="email" placeholder="example@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="password">Password</label>
        <input name="password" type="password" placeholder="password" required>
        
        <label for="confirm_password">Confirm Password</label>
        <input name="confirm_password" type="password" placeholder="confirm password" required>

        <input type="submit" value="Sign Up">
    </form>
    <p class="foot-note">Already have an account? <a href="./?login">Log in here.</a></p>

<?php elseif (isset($_GET['logout'])): ?>
    <?php

    if (!$account->logged_in) {
        header('Location: ./');
        return;
    }

    $_SESSION['token'] = null;

    $account->token->delete();

    header('Location: ./');
    return;
    
    ?>

<?php else: ?>
    <div class="recipes">
        <?php foreach ($random_recipes as $recipe): ?>
            <?= create_recipe_div($recipe)->render() ?>
        <?php endforeach ?>
    </div>

<?php endif ?>

</main>

<script>
    // <?= '' // file_get_contents(__DIR__ . '/../js/scripts.js') ?>
</script>
</body>
</html>
