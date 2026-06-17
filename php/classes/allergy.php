<?php

require_once '_classes.php';

class Allergy
{
    public function __construct(
        public string $ingredient_id,
        public int $allergen_id,
    ) {}

    public static function from_id(string $ingredient_id, int $allergen_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergies` WHERE `ingredient_id` = ? AND `allergen_id` = ?');
        $stmt->bind_param('si', $ingredient_id, $allergen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['ingredient_id'], $result['allergen_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Allergies` (`ingredient_id`, `allergen_id`) VALUES (?, ?)');
        $stmt->bind_param('si', $this->ingredient_id, $this->allergen_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Allergies` WHERE `ingredient_id` = ? AND `allergen_id` = ?');
        $stmt->bind_param('si', $this->ingredient_id, $this->allergen_id);
        return $stmt->execute();
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

    public function get_allergen(): ?Allergen
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Allergens` WHERE `allergen_id` = ?');
        $stmt->bind_param('i', $this->allergen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Allergen($result['allergen_id'], $result['name'], $result['description']);
    }
}
