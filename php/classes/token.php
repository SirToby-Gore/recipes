<?php

require_once '_classes.php';

class Token
{
    public function __construct(
        public string $token,
        public string $user_id,
        public string $created_on,
    ) {}

    public static function from_id(string $token): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Tokens` WHERE `token` = ?');
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['token'], $result['user_id'], $result['created_on']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Tokens` (`token`, `user_id`, `created_on`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->token, $this->user_id, $this->created_on);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Tokens` SET `user_id` = ?, `created_on` = ? WHERE `token` = ?');
        $stmt->bind_param('sss', $this->user_id, $this->created_on, $this->token);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Tokens` WHERE `token` = ?');
        $stmt->bind_param('s', $this->token);
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
}
