<?php

require_once '_classes.php';

class Step
{
    public function __construct(
        public string $step_number,
        public string $recipe_id,
        public string $step,
    ) {}

    public static function from_id(string $step_number, string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Steps` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('ss', $step_number, $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Steps` (`step_number`, `recipe_id`, `step`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->step_number, $this->recipe_id, $this->step);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Steps` SET `step` = ? WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('sss', $this->step, $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Steps` WHERE `step_number` = ? AND `recipe_id` = ?');
        $stmt->bind_param('ss', $this->step_number, $this->recipe_id);
        return $stmt->execute();
    }
}
