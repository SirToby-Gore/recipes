<?php

require_once '_classes.php';

class Tag
{
    public function __construct(
        public string $recipe_id,
        public string $tag_name,
    ) {}

    public static function from_id(string $recipe_id, string $tag_name): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Tags` WHERE `recipe_id` = ? AND `tag_name` = ?');
        $stmt->bind_param('ss', $recipe_id, $tag_name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['tag_name']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Tags` (`recipe_id`, `tag_name`) VALUES (?, ?)');
        $stmt->bind_param('ss', $this->recipe_id, $this->tag_name);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Tags` WHERE `recipe_id` = ? AND `tag_name` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->tag_name);
        return $stmt->execute();
    }
}
