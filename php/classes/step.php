<?php

require_once '_classes.php';

class Step
{
    public function __construct(
        public int $step_number,
        public string $recipe_id,
        public string $step,
    ) {
    }

    public static function from_id(int $step_number, string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Steps` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('is', $step_number, $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result)
            return null;
        return new self($result['step_number'], $result['recipe_id'], $result['step']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Steps` (`step_number`, `recipe_id`, `step`) VALUES (?, ?, ?)');
        $stmt->bind_param('iss', $this->step_number, $this->recipe_id, $this->step);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Steps` SET `step` = ? WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('sis', $this->step, $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Steps` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('is', $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }
}
