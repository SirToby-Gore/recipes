<?php

require_once '_classes.php';

class Allergen
{
    public function __construct(
        public int $allergen_id,
        public string $name,
        public string $description,
    ) {}

    public static function from_id(int $allergen_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergens` WHERE `allergen_id` = ?');
        $stmt->bind_param('i', $allergen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['allergen_id'], $result['name'], $result['description']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Allergens` (`allergen_id`, `name`, `description`) VALUES (?, ?, ?)');
        $stmt->bind_param('iss', $this->allergen_id, $this->name, $this->description);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Allergens` SET `name` = ?, `description` = ? WHERE `allergen_id` = ?');
        $stmt->bind_param('ssi', $this->name, $this->description, $this->allergen_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Allergens` WHERE `allergen_id` = ?');
        $stmt->bind_param('i', $this->allergen_id);
        return $stmt->execute();
    }
}
