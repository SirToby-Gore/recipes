<?php

require_once '_classes.php';

class User
{
    public function __construct(
        public string $user_id,
        public string $name,
        public string $email,
        public string $password_hash,
        public string $salt,
        public string $created_on,
    ) {}

    public static function from_id(string $user_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Users` (`user_id`, `name`, `email`, `password_hash`, `salt`, `created_on`) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $this->user_id, $this->name, $this->email, $this->password_hash, $this->salt, $this->created_on);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Users` SET `name` = ?, `email` = ?, `password_hash` = ?, `salt` = ?, `created_on` = ? WHERE `user_id` = ?');
        $stmt->bind_param('ssssss', $this->name, $this->email, $this->password_hash, $this->salt, $this->created_on, $this->user_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Users` WHERE `user_id` = ?');
        $stmt->bind_param('s', $this->user_id);
        return $stmt->execute();
    }
}
