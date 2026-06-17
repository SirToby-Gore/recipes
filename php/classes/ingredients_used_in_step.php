<?php

require_once '_classes.php';

class IngredientsUsedInStep
{
    public function __construct(
        public string $step_id,
        public string $ingredient_id,
        public float $amount,
        public int $unit_id,
    ) {}

    public static function from_id(string $step_id, string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsUsedInSteps` WHERE `step_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $step_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['step_id'], $result['ingredient_id'], $result['amount'], $result['unit_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `IngredientsUsedInSteps` (`step_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssdi', $this->step_id, $this->ingredient_id, $this->amount, $this->unit_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `IngredientsUsedInSteps` SET `amount` = ?, `unit_id` = ? WHERE `step_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('diss', $this->amount, $this->unit_id, $this->step_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `IngredientsUsedInSteps` WHERE `step_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $this->step_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function get_step(): ?Step
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Steps` WHERE `step_id` = ?');
        $stmt->bind_param('s', $this->step_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Step($result['step_id'], $result['step_number'], $result['recipe_id'], $result['step']);
    }

    public function get_ingredient(): ?Ingredient
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Ingredient($result['ingredient_id'], $result['name'], $result['description'], $result['category']);
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
}
