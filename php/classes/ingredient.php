<?php

require_once '_classes.php';

class Ingredient
{
    public function __construct(
        public string $ingredient_id,
        public string $name,
        public string $description,
    ) {}

    public static function from_id(string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['ingredient_id'], $result['name'], $result['description']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Ingredients` (`ingredient_id`, `name`, `description`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->ingredient_id, $this->name, $this->description);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Ingredients` SET `name` = ?, `description` = ? WHERE `ingredient_id` = ?');
        $stmt->bind_param('sss', $this->name, $this->description, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Ingredients` WHERE `ingredient_id` = ?');
        $stmt->bind_param('s', $this->ingredient_id);
        return $stmt->execute();
    }
}
