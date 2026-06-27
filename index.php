<?php
require_once __DIR__ . '/php/init.php';

$route = get_request_route();

try {
    switch ($route) {
        case '/':
            $search_term = $_GET['search'] ?? null;
            if ($search_term === '' && isset($_GET['search'])) {
                header('Location: /');
                exit;
            }
            render_page_view('home', compact('search_term', 'account'));
            break;


        #region basket

        case '/basket':
            if (!$account) {
                header('Location: /login');
                exit;
            }
            render_page_view('basket', compact('account'));
            break;

        case (preg_match('#^/basket/add/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                respond_with_json_error('Not logged in', 401);
            }
            $recipe = Recipe::from_id($matches[1]);
            if (!$recipe) {
                respond_with_json_error('Recipe does not exist.', 404);
            }
            $item = new Basket($recipe->recipe_id, $account->user_id, 1);
            $item->create();
            create_shopping_list($recipe);
            http_response_code(201);
            exit;

        case (preg_match('#^/basket/increment/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                respond_with_json_error('Not logged in', 401);
            }
            $recipe = Recipe::from_id($matches[1]);
            if (!$recipe) {
                respond_with_json_error('Recipe does not exist.', 404);
            }
            $item = Basket::from_id($recipe->recipe_id, $account->user_id);
            if (!$item) {
                respond_with_json_error('Basket record not found', 400);
            }
            $item->amount += 1;
            $item->update();
            update_shopping_list($recipe, $item);
            respond_with_json_success(['new_amount' => $item->amount]);
            break;

        case (preg_match('#^/basket/decrement/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                respond_with_json_error('Not logged in', 401);
            }
            $recipe = Recipe::from_id($matches[1]);
            if (!$recipe) {
                respond_with_json_error('Recipe does not exist.', 404);
            }
            $item = Basket::from_id($recipe->recipe_id, $account->user_id);
            if (!$item) {
                respond_with_json_error('Basket record not found', 400);
            }
            $item->amount -= 1;
            if ($item->amount <= 0) {
                $item->delete();
                $new_amount = 0;
                delete_shopping_list($recipe);
            } else {
                $item->update();
                $new_amount = $item->amount;
                update_shopping_list($recipe, $item);
            }
            respond_with_json_success(['new_amount' => $new_amount]);
            break;

        case (preg_match('#^/basket/remove/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                respond_with_json_error('Not logged in', 401);
            }
            $recipe = Recipe::from_id($matches[1]);
            if (!$recipe) {
                respond_with_json_error('Recipe does not exist.', 404);
            }
            $item = Basket::from_id($recipe->recipe_id, $account->user_id);
            if (!$item) {
                respond_with_json_error('Basket record not found', 400);
            }
            $item->delete();
            delete_shopping_list($recipe);
            respond_with_json_success();
            break;

        case (preg_match('#^/basket/check/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                respond_with_json_error('Not logged in', 401);
            }
            $shopping_list_item = ShoppingListItem::from_id($account->user_id, $matches[1]);
            if (!$shopping_list_item) {
                respond_with_json_error('Item not found on shopping list', 400);
            }
            $shopping_list_item->is_checked = !$shopping_list_item->is_checked;
            $shopping_list_item->update();
            respond_with_json_success(['is_checked' => $shopping_list_item->is_checked]);
            break;

        #endregion basket

        #region user

        case (preg_match('#^/user/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            $user = get_user($matches[1]);
            if (null === $user) {
                header('Location: /');
                exit;
            }
            render_page_view('user', compact('user', 'account'));
            break;

        case '/register':
            if ($account) {
                header('Location: /');
                exit;
            }
            handle_user_registration();
            break;

        case '/favourites':
            if (!$account) {
                header('Location: /login');
                exit;
            }
            render_page_view('favourites', compact('account'));
            break;

        case '/logout':
            handle_user_logout();
            break;

        case '/login':
            if ($account) {
                header('Location: /');
                exit;
            }
            handle_user_login();
            break;

        case (preg_match('#^/user/preference/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            $new_preference = strtolower($matches[1]);

            update_user_unit_preference($new_preference);

            break;

        #endregion user

        #region recipe

        case (preg_match('#^/recipe/create/(.+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            process_recipe_creation($matches[1]);
            break;

        case '/recipe/create':
            if (!$account) {
                header('Location: /login');
                exit;
            }
            $edit_recipe = null;
            render_page_view('create_recipe', compact('edit_recipe', 'account'));
            break;

        case (preg_match('#^/recipe/fork/([a-zA-Z0-9_-]+)/(.+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            process_recipe_fork_submission($matches[1], $matches[2]);
            break;

        case (preg_match('#^/recipe/fork/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            $edit_recipe = Recipe::from_id($matches[1]);
            if (!$edit_recipe) {
                header('Location: /');
                exit;
            }
            render_page_view('fork_recipe', compact('edit_recipe', 'account'));
            break;

        case (preg_match('#^/recipe/edit/([a-zA-Z0-9_-]+)/(.+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            process_recipe_modification($matches[1], $matches[2]);
            break;

        case (preg_match('#^/recipe/edit/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            $edit_recipe = Recipe::from_id($matches[1]);
            if (!$edit_recipe || $edit_recipe->user_id !== $account->user_id) {
                header('Location: /');
                exit;
            }
            render_page_view('edit_recipe', compact('edit_recipe', 'account'));
            break;

        case (preg_match('#^/recipe/delete/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            process_recipe_deletion($matches[1]);
            break;

        case (preg_match('#^/recipe/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            $recipe = Recipe::from_id($matches[1]);
            if (!$recipe) {
                http_response_code(404);
                render_page_view('errors/404', compact('account'));
                break;
            }
            render_page_view('recipe', compact('recipe', 'account'));
            break;

        case (preg_match('#^/ingredient/?(.*)$#', $route, $matches) ? true : false):
            $path_str = trim($matches[1], '/');
            $searched_ids = $path_str !== '' ? explode('/', $path_str) : [];
            handle_recipe_search_by_ingredients($searched_ids);
            break;

        #endregion recipe

        default:
            http_response_code(404);
            render_page_view('errors/404', compact('account'));
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    file_put_contents(__DIR__ . '/log.your_mum', "\n\n[" . datetime_now() . "]:\n" . $e);
    exit;
}

#region functions

function get_request_route(): string
{
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $script_name = dirname($_SERVER['SCRIPT_NAME']);

    if ('/' !== $script_name) {
        $request_uri = substr($request_uri, strlen($script_name));
    }

    $route = '/' . trim($request_uri, '/');
    return ('//' === $route) ? '/' : $route;
}

function render_page_view(string $view_path, array $context = []): void
{
    extract($context);
    require __DIR__ . '/php/includes/header.php';
    require __DIR__ . "/php/includes/{$view_path}.php";
    require __DIR__ . '/php/includes/footer.php';
}

function respond_with_json_error(string $message, int $status_code = 400): void
{
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode(["error" => $message]);
    exit;
}

function respond_with_json_success(array $data = []): void
{
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => true], $data));
    exit;
}

function handle_user_registration(): void
{
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password_1 = $_POST['password-1'] ?? null;
    $password_2 = $_POST['password-2'] ?? null;

    $name_error = null;
    $email_error = null;
    $password_error = null;

    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        if ($password_1 !== $password_2) {
            $password_error = "Passwords do not match";
        } elseif (strlen($email) > 150) {
            $email_error = "Email is too long, max 150 characters";
        } elseif (!preg_match(RegexExps::$email, $email)) {
            $email_error = "Invalid email address";
        } elseif (email_in_use($email)) {
            $email_error = "Email already in use";
        } elseif (strlen($name) > 100) {
            $name_error = "Name is too long, max 100 characters";
        } elseif (!preg_match(RegexExps::$name, $name)) {
            $name_error = "Invalid name";
        } elseif (name_in_use($name)) {
            $name_error = "Name already in use";
        } else {
            $allowed_regions = ['metric', 'us', 'uk'];

            if (!in_array($_SESSION['preferred_region'], $allowed_regions)) {
                $_SESSION['preferred_region'] = 'metric';
            }

            $salt = random_string(32);
            $new_user = new User(
                new_uuid('user_id', 'Users'),
                $name,
                $email,
                $salt,
                user_hash_password($password_1, $salt),
                datetime_now(),
                $_SESSION['preferred_region'],
            );
            $new_user->create();

            if (login($email, $password_1)) {
                header('Location: /');
                exit;
            }
            header('Location: /login');
            exit;
        }
    }
    render_page_view('register', compact('name_error', 'email_error', 'password_error'));
}

function handle_user_login(): void
{
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $login_error = null;

    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        if (login($email, $password)) {
            header('Location: /');
            exit;
        }
        $login_error = "Invalid email or password combination";
    }
    render_page_view('login', compact('login_error'));
}

function handle_user_logout(): void
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header('Location: /');
    exit;
}

function update_user_unit_preference(string $new_preference): void
{
    global $conn;
    global $account;

    $allowed_regions = ['metric', 'us', 'uk'];

    if (in_array($new_preference, $allowed_regions)) {
        // 1. Update active runtime session state memory
        $_SESSION['preferred_region'] = $new_preference;

        if ($account) {
            $account->unit_preference = $new_preference;
            $account->update();
        }

        respond_with_json_success(['region' => $new_preference]);
    } else {
        respond_with_json_error('Invalid region selection', 400);
    }
}

function process_recipe_creation(string $raw_payload): void
{
    global $conn;
    global $account;

    $decoded_raw = urldecode($raw_payload);
    $recipe_data = json_decode($decoded_raw, true);

    if (!$recipe_data || !isset($recipe_data['name'], $recipe_data['steps']) || empty($recipe_data['steps'])) {
        $_SESSION['form_error'] = "Invalid recipe payload received.";
        header('Location: /recipe/create');
        exit;
    }

    $conn->begin_transaction();
    try {
        $new_recipe_id = new_uuid('recipe_id', 'Recipes');

        $stmt = $conn->prepare("INSERT INTO `Recipes` (`recipe_id`, `title`, `description`, `total_time`, `portions`, `parent`, `user_id`) VALUES (?, ?, ?, ?, ?, NULL, ?)");
        $stmt->bind_param('sssiis', $new_recipe_id, $recipe_data['name'], $recipe_data['description'], $recipe_data['timeMinutes'], $recipe_data['servings'], $account->user_id);
        $stmt->execute();

        save_recipe_child_components($new_recipe_id, $recipe_data);
        $conn->commit();
        unset($_SESSION['form_error']);
        header("Location: /recipe/{$new_recipe_id}");
        exit;
    } catch (Throwable $e) {
        $conn->rollback();

        $_SESSION['form_error'] = $e->getMessage() ?? 'Something went wrong...';

        render_page_view('create_recipe', [
            'account' => $account,
            'recipe_id' => '',
            'title_val' => $recipe_data['name'] ?? '',
            'desc_val' => $recipe_data['description'] ?? '',
            'time_val' => $recipe_data['timeMinutes'] ?? '',
            'servings_val' => $recipe_data['servings'] ?? '',
            'tags_val' => implode(', ', $recipe_data['tags'] ?? []),
            'recipe_steps_payload' => $recipe_data['steps'] ?? [],
            'is_edit_mode' => false
        ]);
        exit;
    }
}

function process_recipe_fork_submission(string $parent_id, string $raw_payload): void
{
    global $conn;
    global $account;

    $recipe_data = json_decode(urldecode($raw_payload), true);

    if (!$recipe_data || !isset($recipe_data['name'], $recipe_data['steps']) || empty($recipe_data['steps'])) {
        $_SESSION['form_error'] = "Invalid fork payload received.";
        header("Location: /recipe/fork/{$parent_id}");
        exit;
    }

    $conn->begin_transaction();
    try {
        $new_recipe_id = new_uuid('recipe_id', 'Recipes');

        $stmt = $conn->prepare("INSERT INTO `Recipes` (`recipe_id`, `title`, `description`, `total_time`, `portions`, `parent`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssiiss', $new_recipe_id, $recipe_data['name'], $recipe_data['description'], $recipe_data['timeMinutes'], $recipe_data['servings'], $parent_id, $account->user_id);
        $stmt->execute();

        save_recipe_child_components($new_recipe_id, $recipe_data);
        $conn->commit();

        header("Location: /recipe/{$new_recipe_id}");
        exit;
    } catch (Throwable $e) {
        $conn->rollback();
        $_SESSION['form_error'] = $e->getMessage();
        header("Location: /recipe/fork/{$parent_id}");
        exit;
    }
}

function process_recipe_modification(string $recipe_id, string $raw_payload): void
{
    global $conn;
    global $account;

    $edit_recipe = Recipe::from_id($recipe_id);
    if (!$edit_recipe || $edit_recipe->user_id !== $account->user_id) {
        http_response_code(403);
        exit;
    }

    $recipe_data = json_decode(urldecode($raw_payload), true);
    if (!$recipe_data || !isset($recipe_data['name'], $recipe_data['steps']) || empty($recipe_data['steps'])) {
        $_SESSION['form_error'] = "Invalid recipe payload received.";
        header("Location: /recipe/edit/{$recipe_id}");
        exit;
    }

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("UPDATE `Recipes` SET `title` = ?, `description` = ?, `total_time` = ?, `portions` = ? WHERE `recipe_id` = ?");
        $stmt->bind_param('ssiis', $recipe_data['name'], $recipe_data['description'], $recipe_data['timeMinutes'], $recipe_data['servings'], $recipe_id);
        $stmt->execute();

        $clear_steps = $conn->prepare("DELETE FROM `Steps` WHERE `recipe_id` = ?");
        $clear_steps->bind_param('s', $recipe_id);
        $clear_steps->execute();

        $clear_tags = $conn->prepare("DELETE FROM `Tags` WHERE `recipe_id` = ?");
        $clear_tags->bind_param('s', $recipe_id);
        $clear_tags->execute();

        save_recipe_child_components($recipe_id, $recipe_data);
        $conn->commit();
        header("Location: /recipe/{$recipe_id}");
        exit;
    } catch (Throwable $exception) {
        $conn->rollback();
        $_SESSION['form_error'] = $exception->getMessage();
        header("Location: /recipe/edit/{$recipe_id}");
        exit;
    }
}

function save_recipe_child_components(string $recipe_id, array $recipe_data): void
{
    global $conn;

    $step_order = 1;
    foreach ($recipe_data['steps'] as $step_data) {
        $new_step_id = new_long_uuid('step_id', 'Steps');
        $step_stmt = $conn->prepare("INSERT INTO `Steps` (`step_id`, `step_number`, `recipe_id`, `step`) VALUES (?, ?, ?, ?)");
        $step_stmt->bind_param('siss', $new_step_id, $step_order, $recipe_id, $step_data['step']);
        $step_stmt->execute();

        if (isset($step_data['ingredients']) && is_array($step_data['ingredients'])) {
            foreach ($step_data['ingredients'] as $ing_data) {
                $ingredient_entity = Ingredient::from_id($ing_data['ingredient_id']);
                $unit_entity = Unit::from_id($ing_data['unit_id']);

                if ($ingredient_entity && $unit_entity) {
                    if (!is_unit_compatible($unit_entity, $ingredient_entity)) {
                        throw new RuntimeException("Incompatible measurement system. Ingredient '{$ingredient_entity->name}' cannot be used with unit '{$unit_entity->short_hand}'");
                    }
                    $step_ing_stmt = $conn->prepare("INSERT INTO `IngredientsUsedInSteps` (`step_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)");
                    $step_ing_stmt->bind_param('ssdi', $new_step_id, $ing_data['ingredient_id'], $ing_data['amount'], $ing_data['unit_id']);
                    $step_ing_stmt->execute();
                }
            }
        }
        $step_order++;
    }

    if (isset($recipe_data['tags']) && is_array($recipe_data['tags'])) {
        foreach ($recipe_data['tags'] as $tag_name) {
            $tag_stmt = $conn->prepare("INSERT INTO `Tags` (`recipe_id`, `tag_name`) VALUES (?, ?)");
            $tag_stmt->bind_param('ss', $recipe_id, $tag_name);
            $tag_stmt->execute();
        }
    }
}

function process_recipe_deletion(string $recipe_id): void
{
    global $conn;
    global $account;

    $recipe = Recipe::from_id($recipe_id);
    if (!$recipe || $recipe->user_id !== $account->user_id) {
        header('Location: /');
        exit;
    }

    $conn->begin_transaction();
    try {
        $queries = [
            "DELETE FROM `Tags` WHERE `recipe_id` = ?",
            "DELETE FROM `IngredientsUsedInSteps` WHERE `step_id` IN (SELECT `step_id` FROM `Steps` WHERE `recipe_id` = ?)",
            "DELETE FROM `Steps` WHERE `recipe_id` = ?",
            "DELETE FROM `CommentLikes` WHERE `comment_id` IN (SELECT `comment_id` FROM `Comments` WHERE `recipe_id` = ?)",
            "DELETE FROM `Comments` WHERE `recipe_id` = ?",
            "DELETE FROM `RecipeLikes` WHERE `recipe_id` = ?",
            "DELETE FROM `RecipeFavourites` WHERE `recipe_id` = ?",
            "DELETE FROM `Recipes` WHERE `recipe_id` = ?"
        ];

        foreach ($queries as $sql) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $recipe_id);
            $stmt->execute();
        }

        $conn->commit();
        if (isset($_SESSION['recipes'][$recipe_id])) {
            unset($_SESSION['recipes'][$recipe_id]);
        }
        header('Location: /user/' . $account->user_id);
        exit;
    } catch (Throwable $exception) {
        $conn->rollback();
        $_SESSION['form_error'] = $exception->getMessage();
        header("Location: /recipe/{$recipe_id}");
        exit;
    }
}

function handle_recipe_search_by_ingredients(array $searched_ids): void
{
    global $conn;
    global $account;

    $recipes = [];
    $focus_ingredient = null;
    $substitutions = [];

    // 1. Fetch all system ingredients to populate the interactive JS Fuzzy Finder
    $ing_stmt = $conn->query("SELECT `ingredient_id`, `name` FROM `Ingredients` ORDER BY `name` ASC");
    $all_ingredients = $ing_stmt->fetch_all(MYSQLI_ASSOC);

    $selected_ingredients = [];

    if (!empty($searched_ids)) {
        $placeholders = implode(',', array_fill(0, count($searched_ids), '?'));

        // 2. Fetch the specific ingredients mapped in the URL path to pre-render the active search tags
        $sel_stmt = $conn->prepare("SELECT `ingredient_id`, `name` FROM `Ingredients` WHERE `ingredient_id` IN ($placeholders)");
        $types = str_repeat('s', count($searched_ids));
        $sel_stmt->bind_param($types, ...$searched_ids);
        $sel_stmt->execute();
        $selected_ingredients = $sel_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // 3. Process the proportional match algorithm
        $sql = <<<SQL
            SELECT 
                r.`recipe_id`, 
                r.`title`, 
                r.`description`, 
                r.`total_time`, 
                r.`portions`,
                COUNT(DISTINCT iuis.`ingredient_id`) as `matching_ingredients_count`,
                (
                    SELECT COUNT(DISTINCT iuis_total.`ingredient_id`)
                    FROM `Steps` s_total
                    JOIN `IngredientsUsedInSteps` iuis_total ON s_total.`step_id` = iuis_total.`step_id`
                    WHERE s_total.`recipe_id` = r.`recipe_id`
                ) as `total_recipe_ingredients`
            FROM `Recipes` r
            JOIN `Steps` s ON r.`recipe_id` = s.`recipe_id`
            JOIN `IngredientsUsedInSteps` iuis ON s.`step_id` = iuis.`step_id`
            WHERE iuis.`ingredient_id` IN ($placeholders)
            GROUP BY r.`recipe_id`
            ORDER BY (COUNT(DISTINCT iuis.`ingredient_id`) / (
                SELECT COUNT(DISTINCT iuis_total.`ingredient_id`)
                FROM `Steps` s_total
                JOIN `IngredientsUsedInSteps` iuis_total ON s_total.`step_id` = iuis_total.`step_id`
                WHERE s_total.`recipe_id` = r.`recipe_id`
            )) DESC
        SQL;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$searched_ids);
        $stmt->execute();
        $recipes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // 4. Capture single-ingredient focused behavior
        if (1 === count($searched_ids)) {
            $focus_id = $searched_ids[0];
            $focus_ingredient = Ingredient::from_id($focus_id);

            if ($focus_ingredient) {
                $sub_stmt = $conn->prepare(<<<SQL
                    SELECT 
                        sub.`description` as `substitution_context`, 
                        i.`name` as `substitute_name`
                    FROM `Substitutions` sub
                    JOIN `Ingredients` i ON sub.`substitution_id` = i.`ingredient_id`
                    WHERE sub.`ingredient_id` = ?
                SQL);
                $sub_stmt->bind_param('s', $focus_id);
                $sub_stmt->execute();
                $substitutions = $sub_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
    }

    render_page_view('ingredient_search', compact('account', 'recipes', 'focus_ingredient', 'substitutions', 'all_ingredients', 'selected_ingredients'));
}

#endregion functions