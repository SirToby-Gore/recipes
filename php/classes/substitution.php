<?php

require_once '_classes.php';

class Substitution
{
    public function __construct(
        public string $ingredient_id,
        public string $substitution_id,
        public string $description,
    ) {}

    public static function from_id(string $ingredient_id, string $substitution_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Substitutions` WHERE `ingredient_id` = ? AND `substitution_id` = ?');
        $stmt->bind_param('ss', $ingredient_id, $substitution_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['ingredient_id'], $result['substitution_id'], $result['description']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Substitutions` (`ingredient_id`, `substitution_id`, `description`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->ingredient_id, $this->substitution_id, $this->description);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Substitutions` SET `description` = ? WHERE `ingredient_id` = ? AND `substitution_id` = ?');
        $stmt->bind_param('sss', $this->description, $this->ingredient_id, $this->substitution_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Substitutions` WHERE `ingredient_id` = ? AND `substitution_id` = ?');
        $stmt->bind_param('ss', $this->ingredient_id, $this->substitution_id);
        return $stmt->execute();
    }
}
