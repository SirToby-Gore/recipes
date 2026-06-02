<?php

require_once '_classes.php';

class Lik
{
    public function __construct(
        public string $comment_id,
        public string $recipe_id,
        public string $user_id,
    ) {}

    public static function from_id(string $comment_id, string $recipe_id, string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Likes` WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('sss', $comment_id, $recipe_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Likes` (`comment_id`, `recipe_id`, `user_id`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->comment_id, $this->recipe_id, $this->user_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Likes` SET  WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('sss', $this->comment_id, $this->recipe_id, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Likes` WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ?');
        $stmt->bind_param('sss', $this->comment_id, $this->recipe_id, $this->user_id);
        return $stmt->execute();
    }
}
