<?php

require_once '_classes.php';

class Basket
{
    public function __construct(
        public string $recipe_id,
        public string $user_id,
        public int $amount,
    ) {}

    public static function from_id(string $recipe_id, string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Baskets` WHERE `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('ss', $recipe_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['user_id'], $result['amount']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Baskets` (`recipe_id`, `user_id`, `amount`) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $this->recipe_id, $this->user_id, $this->amount);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Baskets` SET `amount` = ? WHERE `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('iss', $this->amount, $this->recipe_id, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Baskets` WHERE `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->user_id);
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

    public function get_user(): ?User
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new User($result['user_id'], $result['username'], $result['email'], $result['salt'], $result['password_hash'], $result['created_on']);
    }
}
