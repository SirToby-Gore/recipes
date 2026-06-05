<?php

require_once '_classes.php';

class Like
{
    public function __construct(
        public string $recipe_id,
        public string $comment_id,
        public string $user_id,
    ) {}

    public static function from_id(string $recipe_id, string $comment_id, string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Likes` WHERE `recipe_id` = ? AND `comment_id` = ? AND `user_id` = ?');
        $stmt->bind_param('sss', $recipe_id, $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['recipe_id'], $result['comment_id'], $result['user_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Likes` (`recipe_id`, `comment_id`, `user_id`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->recipe_id, $this->comment_id, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Likes` WHERE `recipe_id` = ? AND `comment_id` = ? AND `user_id` = ?');
        $stmt->bind_param('sss', $this->recipe_id, $this->comment_id, $this->user_id);
        return $stmt->execute();
    }
}
