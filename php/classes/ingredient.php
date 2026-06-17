<?php

require_once '_classes.php';

class Ingredient
{
    public function __construct(
        public string $ingredient_id,
        public string $name,
        public string $description,
        public string $category,
    ) {}

    public static function from_id(string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['ingredient_id'], $result['name'], $result['description'], $result['category']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Ingredients` (`ingredient_id`, `name`, `description`, `category`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $this->ingredient_id, $this->name, $this->description, $this->category);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Ingredients` SET `name` = ?, `description` = ?, `category` = ? WHERE `ingredient_id` = ?');
        $stmt->bind_param('ssss', $this->name, $this->description, $this->category, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        return $stmt->execute();
    }

    public function get_ingredients_used_in_steps(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsUsedInSteps` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new IngredientsUsedInStep($row['step_id'], $row['ingredient_id'], $row['amount'], $row['unit_id']);
        }
        return $items;
    }

    public function get_allergies(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergies` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Allergy($row['ingredient_id'], $row['allergen_id']);
        }
        return $items;
    }

    public function get_substitutions_by_ingredient_id(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Substitutions` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Substitution($row['ingredient_id'], $row['substitution_id'], $row['description']);
        }
        return $items;
    }

    public function get_substitutions_by_substitution_id(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Substitutions` WHERE `substitution_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Substitution($row['ingredient_id'], $row['substitution_id'], $row['description']);
        }
        return $items;
    }

    public function get_shopping_list_items(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `ShoppingListItems` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new ShoppingListItem($row['user_id'], $row['ingredient_id'], $row['recipe_id'], $row['amount'], $row['unit_id'], $row['is_checked']);
        }
        return $items;
    }

    public function get_recipes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `Recipes`.* FROM `Recipes` JOIN `Steps` ON `Steps`.`recipe_id` = `Recipes`.`recipe_id` JOIN `IngredientsUsedInSteps` ON `IngredientsUsedInSteps`.`step_id` = `Steps`.`step_id` JOIN `Ingredients` ON `Ingredients`.`ingredient_id` = `IngredientsUsedInSteps`.`ingredient_id` WHERE `Ingredients`.`ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Recipe($row['recipe_id'], $row['title'], $row['description'], $row['total_time'], $row['portions'], $row['parent'], $row['user_id']);
        }
        return $items;
    }
}
