<?php

require_once '_classes.php';

class Comment
{
    public function __construct(
        public string $comment_id,
        public string $recipe_id,
        public string $body,
        public string $user_id,
        public string $created_on,
    ) {}

    public static function from_id(string $comment_id, string $recipe_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `comment_id` = ? AND `recipe_id` = ?');
        $stmt->bind_param('ss', $comment_id, $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Comments` (`comment_id`, `recipe_id`, `body`, `user_id`, `created_on`) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $this->comment_id, $this->recipe_id, $this->body, $this->user_id, $this->created_on);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Comments` SET `body` = ?, `user_id` = ?, `created_on` = ? WHERE `comment_id` = ? AND `recipe_id` = ?');
        $stmt->bind_param('sssss', $this->body, $this->user_id, $this->created_on, $this->comment_id, $this->recipe_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Comments` WHERE `comment_id` = ? AND `recipe_id` = ?');
        $stmt->bind_param('ss', $this->comment_id, $this->recipe_id);
        return $stmt->execute();
    }
}
