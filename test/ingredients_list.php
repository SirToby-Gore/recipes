<?php

require_once '_classes.php';

class IngredientsList
{
    public function __construct(
        public string $recipe_id,
        public string $ingredient_id,
        public float $amount,
        public string $unit_id,
    ) {}

    public static function from_id(string $recipe_id, string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Ingredientslist` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $recipe_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Ingredientslist` (`recipe_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssds', $this->recipe_id, $this->ingredient_id, $this->amount, $this->unit_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Ingredientslist` SET `amount` = ?, `unit_id` = ? WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('dsss', $this->amount, $this->unit_id, $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Ingredientslist` WHERE `recipe_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->ingredient_id);
        return $stmt->execute();
    }
}
