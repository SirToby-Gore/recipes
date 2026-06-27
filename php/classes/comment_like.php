<?php

require_once '_classes.php';

class CommentLike
{
    public function __construct(
        public string $comment_id,
        public string $user_id,
    ) {}

    public static function from_id(string $comment_id, string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CommentLikes` WHERE `comment_id` = ? AND `user_id` = ?');
        $stmt->bind_param('ss', $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['comment_id'], $result['user_id']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `CommentLikes` (`comment_id`, `user_id`) VALUES (?, ?)');
        $stmt->bind_param('ss', $this->comment_id, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `CommentLikes` WHERE `comment_id` = ? AND `user_id` = ?');
        $stmt->bind_param('ss', $this->comment_id, $this->user_id);
        return $stmt->execute();
    }

    public function get_comment(): ?Comment
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `comment_id` = ?');
        $stmt->bind_param('s', $this->comment_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Comment($result['comment_id'], $result['recipe_id'], $result['user_id'], $result['created_on'], $result['body'], $result['last_edited']);
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
}
