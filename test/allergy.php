<?php

require_once '_classes.php';

class Allergy
{
    public function __construct(
        public string $ingredient_id,
        public string $allergen,
    ) {}

    public static function from_id(string $ingredient_id, string $allergen): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergy` WHERE `ingredient_id` = ? AND `allergen` = ?');
        $stmt->bind_param('ss', $ingredient_id, $allergen);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Allergy` (`ingredient_id`, `allergen`) VALUES (?, ?)');
        $stmt->bind_param('ss', $this->ingredient_id, $this->allergen);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Allergy` SET  WHERE `ingredient_id` = ? AND `allergen` = ?');
        $stmt->bind_param('ss', , $this->ingredient_id, $this->allergen);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Allergy` WHERE `ingredient_id` = ? AND `allergen` = ?');
        $stmt->bind_param('ss', $this->ingredient_id, $this->allergen);
        return $stmt->execute();
    }
}
