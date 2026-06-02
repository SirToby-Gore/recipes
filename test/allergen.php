<?php

require_once '_classes.php';

class Allergen
{
    public function __construct(
        public string $allergen_id,
        public string $name,
        public string $description,
    ) {}

    public static function from_id(string $allergen_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergens` WHERE `allergen_id` = ?');
        $stmt->bind_param('s', $allergen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Allergens` (`allergen_id`, `name`, `description`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->allergen_id, $this->name, $this->description);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Allergens` SET `name` = ?, `description` = ? WHERE `allergen_id` = ?');
        $stmt->bind_param('sss', $this->name, $this->description, $this->allergen_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Allergens` WHERE `allergen_id` = ?');
        $stmt->bind_param('s', $this->allergen_id);
        return $stmt->execute();
    }
}
