<?php

require_once '_classes.php';

class Unit
{
    public function __construct(
        public string $unit_id,
        public string $name,
        public string $short_hand,
    ) {}

    public static function from_id(string $unit_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('s', $unit_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Units` (`unit_id`, `name`, `short_hand`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->unit_id, $this->name, $this->short_hand);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Units` SET `name` = ?, `short_hand` = ? WHERE `unit_id` = ?');
        $stmt->bind_param('sss', $this->name, $this->short_hand, $this->unit_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('s', $this->unit_id);
        return $stmt->execute();
    }
}
