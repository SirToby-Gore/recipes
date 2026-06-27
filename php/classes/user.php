<?php

require_once '_classes.php';

class User
{
    public function __construct(
        public string $user_id,
        public string $username,
        public string $email,
        public string $salt,
        public string $password_hash,
        public string $created_on,
        public string $unit_preference,
    ) {}

    public static function from_id(string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['user_id'], $result['username'], $result['email'], $result['salt'], $result['password_hash'], $result['created_on'], $result['unit_preference']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Users` (`user_id`, `username`, `email`, `salt`, `password_hash`, `created_on`, `unit_preference`) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssss', $this->user_id, $this->username, $this->email, $this->salt, $this->password_hash, $this->created_on, $this->unit_preference);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Users` SET `username` = ?, `email` = ?, `salt` = ?, `password_hash` = ?, `created_on` = ?, `unit_preference` = ? WHERE `user_id` = ?');
        $stmt->bind_param('sssssss', $this->username, $this->email, $this->salt, $this->password_hash, $this->created_on, $this->unit_preference, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        return $stmt->execute();
    }

    public function get_tokens(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Tokens` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Token($row['token'], $row['user_id'], $row['created_on']);
        }
        return $items;
    }

    public function get_recipes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Recipe($row['recipe_id'], $row['title'], $row['description'], $row['total_time'], $row['portions'], $row['parent'], $row['user_id']);
        }
        return $items;
    }

    public function get_baskets(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Baskets` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Basket($row['recipe_id'], $row['user_id'], $row['amount']);
        }
        return $items;
    }

    public function get_recipe_likes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `RecipeLikes` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new RecipeLike($row['recipe_id'], $row['user_id']);
        }
        return $items;
    }

    public function get_recipe_favourites(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `RecipeFavourites` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new RecipeFavourite($row['recipe_id'], $row['user_id']);
        }
        return $items;
    }

    public function get_comments(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Comment($row['comment_id'], $row['recipe_id'], $row['user_id'], $row['created_on'], $row['body'], $row['last_edited']);
        }
        return $items;
    }

    public function get_comment_likes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CommentLikes` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new CommentLike($row['comment_id'], $row['user_id']);
        }
        return $items;
    }

    public function get_shopping_list_items(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `ShoppingListItems` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new ShoppingListItem($row['user_id'], $row['ingredient_id'], $row['recipe_id'], $row['amount'], $row['unit_id'], $row['is_checked']);
        }
        return $items;
    }

    public function get_liked_tags(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `Tags`.* FROM `Tags` JOIN `RecipeLikes` ON `RecipeLikes`.`recipe_id` = `Tags`.`recipe_id` JOIN `Users` ON `Users`.`user_id` = `RecipeLikes`.`user_id` WHERE `Users`.`user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Tag($row['recipe_id'], $row['tag_name']);
        }
        return $items;
    }

    public function get_favourite_tags(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `Tags`.* FROM `Tags` JOIN `RecipeFavourites` ON `RecipeFavourites`.`recipe_id` = `Tags`.`recipe_id` JOIN `Users` ON `Users`.`user_id` = `RecipeFavourites`.`user_id` WHERE `Users`.`user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Tag($row['recipe_id'], $row['tag_name']);
        }
        return $items;
    }

    public function get_favourite_recipes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `Recipes`.* FROM `Recipes` JOIN `RecipeFavourites` ON `RecipeFavourites`.`recipe_id` = `Recipes`.`recipe_id` JOIN `Users` ON `Users`.`user_id` = `RecipeFavourites`.`user_id` WHERE `Users`.`user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Recipe($row['recipe_id'], $row['title'], $row['description'], $row['total_time'], $row['portions'], $row['parent'], $row['user_id']);
        }
        return $items;
    }
}
