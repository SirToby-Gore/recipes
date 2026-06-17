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

    public static function from_id(string $comment_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Comments` WHERE `comment_id` = ?');
        $stmt->bind_param('s', $comment_id);
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
        $stmt = $conn->prepare('UPDATE `Comments` SET `recipe_id` = ?, `user_id` = ?, `created_on` = ?, `body` = ?, `last_edited` = ? WHERE `comment_id` = ?');
        $stmt->bind_param('ssssss', $this->recipe_id, $this->user_id, $this->created_on, $this->body, $this->last_edited, $this->comment_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Comments` WHERE `comment_id` = ?');
        $stmt->bind_param('s', $this->comment_id);
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

    public function get_comment_likes(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CommentLikes` WHERE `comment_id` = ?');
        $stmt->bind_param('s', $this->comment_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new CommentLike($row['comment_id'], $row['user_id']);
        }
        return $items;
    }
}
