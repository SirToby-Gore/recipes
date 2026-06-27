<?php

require_once '_classes.php';

class Recipe
{
    public function __construct(
        public string $recipe_id,
        public string $title,
        public string $description,
        public int $total_time,
        public int $portions,
        public ?string $parent,
        public string $user_id,
    ) {}

    public static function from_id(string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['title'], $result['description'], $result['total_time'], $result['portions'], $result['parent'], $result['user_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Recipes` (`recipe_id`, `title`, `description`, `total_time`, `portions`, `parent`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssiiss', $this->recipe_id, $this->title, $this->description, $this->total_time, $this->portions, $this->parent, $this->user_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Recipes` SET `title` = ?, `description` = ?, `total_time` = ?, `portions` = ?, `parent` = ?, `user_id` = ? WHERE `recipe_id` = ?');
        $stmt->bind_param('ssiisss', $this->title, $this->description, $this->total_time, $this->portions, $this->parent, $this->user_id, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        return $stmt->execute();
    }

    public function get_parent(): ?Recipe
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->parent);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Recipe($result['recipe_id'], $result['title'], $result['description'], $result['total_time'], $result['portions'], $result['parent'], $result['user_id']);
    }

    public function get_user(): ?User
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new User($result['user_id'], $result['username'], $result['email'], $result['salt'], $result['password_hash'], $result['created_on'], $result['unit_preference']);
    }

    public function get_recipes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `parent` = ?');
        $stmt->bind_param('s', $this->recipe_id);
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
        $stmt = $conn->prepare('SELECT * FROM `Baskets` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
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
        $stmt = $conn->prepare('SELECT * FROM `RecipeLikes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
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
        $stmt = $conn->prepare('SELECT * FROM `RecipeFavourites` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new RecipeFavourite($row['recipe_id'], $row['user_id']);
        }
        return $items;
    }

    public function get_steps(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Steps` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Step($row['step_id'], $row['step_number'], $row['recipe_id'], $row['step']);
        }
        return $items;
    }

    public function get_tags(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Tags` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Tag($row['recipe_id'], $row['tag_name']);
        }
        return $items;
    }

    public function get_comments(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Comment($row['comment_id'], $row['recipe_id'], $row['user_id'], $row['created_on'], $row['body'], $row['last_edited']);
        }
        return $items;
    }

    public function get_shopping_list_items(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `ShoppingListItems` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new ShoppingListItem($row['user_id'], $row['ingredient_id'], $row['recipe_id'], $row['amount'], $row['unit_id'], $row['is_checked']);
        }
        return $items;
    }

    public function get_allergens(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `Allergens`.* FROM `Allergens` JOIN `Allergies` ON `Allergies`.`allergen_id` = `Allergens`.`allergen_id` JOIN `IngredientsUsedInSteps` ON `IngredientsUsedInSteps`.`ingredient_id` = `Allergies`.`ingredient_id` JOIN `Steps` ON `Steps`.`step_id` = `IngredientsUsedInSteps`.`step_id` JOIN `Recipes` ON `Recipes`.`recipe_id` = `Steps`.`recipe_id` WHERE `Recipes`.`recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Allergen($row['allergen_id'], $row['name'], $row['description']);
        }
        return $items;
    }

    public function get_ingredients_list(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `IngredientsUsedInSteps`.* FROM `IngredientsUsedInSteps` JOIN `Steps` ON `Steps`.`step_id` = `IngredientsUsedInSteps`.`step_id` JOIN `Recipes` ON `Recipes`.`recipe_id` = `Steps`.`recipe_id` WHERE `Recipes`.`recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new IngredientsUsedInStep($row['step_id'], $row['ingredient_id'], $row['amount'], $row['unit_id']);
        }
        return $items;
    }

    public function get_like_count(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `RecipeLikes`.* FROM `RecipeLikes` JOIN `Recipes` ON `Recipes`.`recipe_id` = `RecipeLikes`.`recipe_id` WHERE `Recipes`.`recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new RecipeLike($row['recipe_id'], $row['user_id']);
        }
        return $items;
    }

    public function get_favourite_count(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `RecipeFavourites`.* FROM `RecipeFavourites` JOIN `Recipes` ON `Recipes`.`recipe_id` = `RecipeFavourites`.`recipe_id` WHERE `Recipes`.`recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new RecipeFavourite($row['recipe_id'], $row['user_id']);
        }
        return $items;
    }
}
