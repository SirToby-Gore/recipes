<?php

require_once '_classes.php';

class IngredientsList
{
    public function __construct(
        public string $recipe_id,
        public string $ingredient_id,
        public float $amount,
        public int $unit_id,
    ) {}

    public static function from_id(string $recipe_id, string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsLists` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $recipe_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['ingredient_id'], $result['amount'], $result['unit_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `IngredientsLists` (`recipe_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssdi', $this->recipe_id, $this->ingredient_id, $this->amount, $this->unit_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `IngredientsLists` SET `amount` = ?, `unit_id` = ? WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('diss', $this->amount, $this->unit_id, $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `IngredientsLists` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function get_recipe(): ?Recipe
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Recipe($result['recipe_id'], $result['title'], $result['description'], $result['total_time'], $result['portions'], $result['parent'], $result['user_id']);
    }

    public function get_ingredient(): ?Ingredient
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Ingredient($result['ingredient_id'], $result['name'], $result['description']);
    }

    public function get_unit(): ?Unit
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->unit_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Unit($result['unit_id'], $result['short_hand']);
    }

    public function get_ingredients_used_in_steps(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT `IngredientsUsedInSteps`.* FROM `IngredientsUsedInSteps` JOIN `Steps` ON `Steps`.`step_id` = `IngredientsUsedInSteps`.`step_id` AND `Steps`.`ingredient_id` = `IngredientsUsedInSteps`.`ingredient_id` JOIN `IngredientsLists` ON `IngredientsLists`.`recipe_id` = `Steps`.`recipe_id` WHERE `IngredientsLists`.`recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new IngredientsUsedInStep($row['step_id'], $row['ingredient_id'], $row['amount'], $row['unit']);
        }
        return $items;
    }
}
