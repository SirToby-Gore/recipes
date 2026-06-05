<?php

require_once '_classes.php';

class Recip
{
    public function __construct(
        public string $recipe_id,
        public string $title,
        public string $description,
        public int $number_of_steps,
        public int $total_time,
        public int $portions,
        public ?string $parent,
        public string $user_id,
    ) {}

    public static function from_id(string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['title'], $result['description'], $result['number_of_steps'], $result['total_time'], $result['portions'], $result['parent'], $result['user_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Recipes` (`recipe_id`, `title`, `description`, `number_of_steps`, `total_time`, `portions`, `parent`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssiiiss', $this->recipe_id, $this->title, $this->description, $this->number_of_steps, $this->total_time, $this->portions, $this->parent, $this->user_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Recipes` SET `title` = ?, `description` = ?, `number_of_steps` = ?, `total_time` = ?, `portions` = ?, `parent` = ?, `user_id` = ? WHERE `recipe_id` = ?');
        $stmt->bind_param('ssiiisss', $this->title, $this->description, $this->number_of_steps, $this->total_time, $this->portions, $this->parent, $this->user_id, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Recipes` WHERE `recipe_id` = ?');
        $stmt->bind_param('s', $this->recipe_id);
        return $stmt->execute();
    }
}
