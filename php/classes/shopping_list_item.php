<?php

require_once '_classes.php';

class ShoppingListItem
{
    public function __construct(
        public string $user_id,
        public string $ingredient_id,
        public ?string $recipe_id,
        public float $amount,
        public int $unit_id,
        public bool $is_checked,
    ) {}

    public static function from_id(string $user_id, string $ingredient_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `ShoppingListItems` WHERE `user_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $user_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['user_id'], $result['ingredient_id'], $result['recipe_id'], $result['amount'], $result['unit_id'], $result['is_checked']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `ShoppingListItems` (`user_id`, `ingredient_id`, `recipe_id`, `amount`, `unit_id`, `is_checked`) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssdii', $this->user_id, $this->ingredient_id, $this->recipe_id, $this->amount, $this->unit_id, $this->is_checked);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `ShoppingListItems` SET `recipe_id` = ?, `amount` = ?, `unit_id` = ?, `is_checked` = ? WHERE `user_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('sdiiss', $this->recipe_id, $this->amount, $this->unit_id, $this->is_checked, $this->user_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `ShoppingListItems` WHERE `user_id` = ? AND `ingredient_id` = ?');
        $stmt->bind_param('ss', $this->user_id, $this->ingredient_id);
        return $stmt->execute();
    }

    public function get_user(): ?User
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new User($result['user_id'], $result['username'], $result['email'], $result['salt'], $result['password_hash'], $result['created_on'], $result['unit_preference']);
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
