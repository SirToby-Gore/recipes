<?php

require_once '_classes.php';

class Comment
{
    public function __construct(
        public string $comment_id,
        public string $recipe_id,
        public string $user_id,
        public string $created_on,
        public string $body,
        public ?string $last_edited,
    ) {}

    public static function from_id(string $comment_id, string $recipe_id, string $user_id, string $created_on): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ? AND `created_on` = ?');
        $stmt->bind_param('ssss', $comment_id, $recipe_id, $user_id, $created_on);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['comment_id'], $result['recipe_id'], $result['user_id'], $result['created_on'], $result['body'], $result['last_edited']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Comments` (`comment_id`, `recipe_id`, `user_id`, `created_on`, `body`, `last_edited`) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $this->comment_id, $this->recipe_id, $this->user_id, $this->created_on, $this->body, $this->last_edited);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Comments` SET `body` = ?, `last_edited` = ? WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ? AND `created_on` = ?');
        $stmt->bind_param('ssssss', $this->body, $this->last_edited, $this->comment_id, $this->recipe_id, $this->user_id, $this->created_on);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Comments` WHERE `comment_id` = ? AND `recipe_id` = ? AND `user_id` = ? AND `created_on` = ?');
        $stmt->bind_param('ssss', $this->comment_id, $this->recipe_id, $this->user_id, $this->created_on);
        return $stmt->execute();
    }
}
