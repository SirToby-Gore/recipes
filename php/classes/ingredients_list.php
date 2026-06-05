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
        $stmt = $conn->prepare('SELECT * FROM `IngredientsList` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $recipe_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['ingredient_id'], $result['amount'], $result['unit_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `IngredientsList` (`recipe_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssdi', $this->recipe_id, $this->ingredient_id, $this->amount, $this->unit_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `IngredientsList` SET `amount` = ?, `unit_id` = ? WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('diss', $this->amount, $this->unit_id, $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `IngredientsList` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }
}
