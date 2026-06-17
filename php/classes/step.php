<?php

require_once '_classes.php';

class Step
{
    public function __construct(
        public string $step_id,
        public int $step_number,
        public string $recipe_id,
        public string $step,
    ) {}

    public static function from_id(string $step_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Steps` WHERE `step_id` = ?');
        $stmt->bind_param('s', $step_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['step_id'], $result['step_number'], $result['recipe_id'], $result['step']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Steps` (`step_id`, `step_number`, `recipe_id`, `step`) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('siss', $this->step_id, $this->step_number, $this->recipe_id, $this->step);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Steps` SET `step_number` = ?, `recipe_id` = ?, `step` = ? WHERE `step_id` = ?');
        $stmt->bind_param('isss', $this->step_number, $this->recipe_id, $this->step, $this->step_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Steps` WHERE `step_id` = ?');
        $stmt->bind_param('s', $this->step_id);
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

    public function get_ingredients_used_in_steps(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsUsedInSteps` WHERE `step_id` = ?');
        $stmt->bind_param('s', $this->step_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new IngredientsUsedInStep($row['step_id'], $row['ingredient_id'], $row['amount'], $row['unit_id']);
        }
        return $items;
    }
}
