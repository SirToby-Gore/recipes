<?php

require_once '_classes.php';

class Tag
{
    public function __construct(
        public string $tag_id,
        public string $name,
    ) {}

    public static function from_id(string $tag_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Tags` WHERE `tag_id` = ?');
        $stmt->bind_param('s', $tag_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Tags` (`tag_id`, `name`) VALUES (?, ?)');
        $stmt->bind_param('ss', $this->tag_id, $this->name);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Tags` SET `name` = ? WHERE `tag_id` = ?');
        $stmt->bind_param('ss', $this->name, $this->tag_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Tags` WHERE `tag_id` = ?');
        $stmt->bind_param('s', $this->tag_id);
        return $stmt->execute();
    }
}
