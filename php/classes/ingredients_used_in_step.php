<?php

require_once '_classes.php';

class IngredientsUsedInStep
{
    public function __construct(
        public int $step_number,
        public string $recipe_id,
        public string $ingredient_id,
        public float $amount,
        public int $unit,
    ) {}

    public static function from_id(int $step_number, string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsUsedInStep` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('is', $step_number, $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['step_number'], $result['recipe_id'], $result['ingredient_id'], $result['amount'], $result['unit']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `IngredientsUsedInStep` (`step_number`, `recipe_id`, `ingredient_id`, `amount`, `unit`) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('issdi', $this->step_number, $this->recipe_id, $this->ingredient_id, $this->amount, $this->unit);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `IngredientsUsedInStep` SET `ingredient_id` = ?, `amount` = ?, `unit` = ? WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('sdiis', $this->ingredient_id, $this->amount, $this->unit, $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `IngredientsUsedInStep` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('is', $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }
}
