<?php
require_once __DIR__ . '/php/init.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$script_name = dirname($_SERVER['SCRIPT_NAME']);
if ('/' != $script_name) {
    $request_uri = substr($request_uri, strlen($script_name));
}

$route = '/' . trim($request_uri, '/');
if ('//' == $route) {
    $route = '/';
}

try {
    switch ($route) {
        case '/':
            $search_term = $_GET['search'] ?? null;

            // If search key is present but empty, redirect cleanly
            if ($search_term === '' && isset($_GET['search'])) {
                header('Location: /');
                exit;
            }

            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/home.php';
            require __DIR__ . '/php/includes/footer.php';
            break;

        #region basket

        case '/basket':
            if (!$account) {
                header('Location: /login');
                exit;
            }
            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/basket.php';
            require __DIR__ . '/php/includes/footer.php';
            break;

        case (preg_match('#^/basket/add/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }

            $recipe_id = $matches[1];

            $recipe_check = Recipe::from_id($recipe_id);
            if (!$recipe_check) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Recipe does not exist."]);
                exit;
            }

            $item = new Basket($recipe_id, $account->user_id, 1);
            $item->create();

            create_shopping_list($recipe_check);

            http_response_code(201);
            exit;


        case (preg_match('#^/basket/increment/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                http_response_code(401); // Unauthorized
                echo json_encode(['error' => 'Not logged in']);
                exit;
            }
            $recipe_id = $matches[1];

            $recipe_check = Recipe::from_id($recipe_id);
            if (!$recipe_check) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Recipe does not exist."]);
                exit;
            }

            // Fixed Parameter Order: (recipe_id, user_id) matching table PRIMARY KEY layout
            $item = Basket::from_id($recipe_id, $account->user_id);
            if ($item) {
                $item->amount += 1;
                $item->update();

                update_shopping_list($recipe_check, $item);

                // Return a successful JSON validation to stop fetch from dropping into catch blocks
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'new_amount' => $item->amount]);
                exit;
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Basket record not found']);
                exit;
            }
            break;

        case (preg_match('#^/basket/decrement/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                http_response_code(401);
                exit;
            }
            $recipe_id = $matches[1];

            $recipe_check = Recipe::from_id($recipe_id);
            if (!$recipe_check) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Recipe does not exist."]);
                exit;
            }

            // Fixed Parameter Order: (recipe_id, user_id)
            $item = Basket::from_id($recipe_id, $account->user_id);
            if ($item) {
                $item->amount -= 1;
                if ($item->amount <= 0) {
                    $item->delete();
                    $new_amount = 0;
                    delete_shopping_list($recipe_check);
                } else {
                    $item->update();
                    $new_amount = $item->amount;
                    update_shopping_list($recipe_check, $item);
                }
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'new_amount' => $new_amount]);
                exit;
            } else {
                http_response_code(400);
                exit;
            }
            break;

        case (preg_match('#^/basket/remove/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                http_response_code(401);
                exit;
            }
            $recipe_id = $matches[1];

            $recipe_check = Recipe::from_id($recipe_id);
            if (!$recipe_check) {
                http_response_code(404); // Not Found
                echo json_encode(["error" => "Recipe does not exist."]);
                exit;
            }

            // Fixed Parameter Order: (recipe_id, user_id)
            $item = Basket::from_id($recipe_id, $account->user_id);
            if ($item) {
                $item->delete();

                delete_shopping_list($recipe_check);

                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                http_response_code(400);
                exit;
            }
            break;

        case (preg_match('#^/basket/check/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                http_response_code(401);
                exit;
            }
            $ingredient_id = $matches[1];
            $shopping_list_item = ShoppingListItem::from_id($account->user_id, $ingredient_id);
            if ($shopping_list_item) {
                $shopping_list_item->is_checked = !$shopping_list_item->is_checked;
                $shopping_list_item->update();

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'is_checked' => $shopping_list_item->is_checked]);
                exit;
            } else {
                http_response_code(400);
                exit;
            }
            break;
        #endregion basket

        #region user

        // Match: View user profile
        case (preg_match('#^/user/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            $user_id = $matches[1];
            $user = get_user($user_id);

            if (null === $user) {
                header('Location: /');
                exit;
            }

            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/user.php';
            require __DIR__ . '/php/includes/footer.php';
            break;

        case '/register':
            if ($account) {
                header('Location: /');
                exit;
            }

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
                    $salt = random_string(32);
                    $new_user = new User(
                        new_uuid('user_id', 'Users'),
                        $name,
                        $email,
                        $salt,
                        user_hash_password($password_1, $salt),
                        datetime_now()
                    );

                    $new_user->create();

                    if (login($email, $password_1)) {
                        header('Location: /');
                        exit;
                    } else {
                        header('Location: /login');
                        exit;
                    }
                }
            }

            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/register.php';
            require __DIR__ . '/php/includes/footer.php';
            break;


        case '/favourites':
            if (!$account) {
                header('Location: /login');
                exit;
            }
            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/favourites.php';
            require __DIR__ . '/php/includes/footer.php';
            break;


        case '/logout':
            // Destroy session details safely and redirect home
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

        case '/login':
            if ($account) {
                header('Location: /');
                exit;
            }

            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $login_error = null;

            if ('POST' === $_SERVER['REQUEST_METHOD']) {
                if (login($email, $password)) {
                    header('Location: /');
                    exit;
                } else {
                    $login_error = "Invalid email or password combination";
                }
            }

            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/login.php';
            require __DIR__ . '/php/includes/footer.php';
            break;

        #endregion user

        #region recipe

        // Match: View single recipe
        case (preg_match('#^/recipe/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            $recipe_id = $matches[1];
            $recipe = Recipe::from_id($recipe_id);

            if (!$recipe) {
                http_response_code(404);
                require __DIR__ . '/php/includes/header.php';
                require __DIR__ . '/php/includes/errors/404.php';
                require __DIR__ . '/php/includes/footer.php';
                break;

            }

            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/recipe.php';
            require __DIR__ . '/php/includes/footer.php';
            break;


        // Match: Toggle Recipe Like Status
        case (preg_match('#^/recipe/like/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            $recipe_id = $matches[1];
            toggle_recipe_like($recipe_id, $account->user_id);
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;


        // Match: Toggle Recipe Favourite Status
        case (preg_match('#^/recipe/favourite/([a-zA-Z0-9-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                header('Location: /login');
                exit;
            }
            $recipe_id = $matches[1];
            toggle_recipe_favourite($recipe_id, $account->user_id);
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;

        case (preg_match('#^/comment/like/([a-zA-Z0-9_-]+)$#', $route, $matches) ? true : false):
            if (!$account) {
                http_response_code(401);
                exit;
            }
            $comment_id = $matches[1];
            $like = CommentLike::from_id($comment_id, $account->user_id);
            if ($like) {
                $like->delete();
                $is_liked = false;
            } else {
                $like = new CommentLike($comment_id, $account->user_id);
                $like->create();
                $is_liked = true;
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'is_liked' => $is_liked]);
            exit;

        #endregion recipe

        default:
            http_response_code(404);
            require __DIR__ . '/php/includes/header.php';
            require __DIR__ . '/php/includes/errors/404.php';
            require __DIR__ . '/php/includes/footer.php';
            break;
    }
} catch (Exception $e) {
    http_response_code(500);

    echo $e;

    file_put_contents(__DIR__ . '/log.txt', "\n\n[" . datetime_now() . "]:\n" . $e);

    exit;
}