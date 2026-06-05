<?php

require_once '_classes.php';

class Unit
{
    public function __construct(
        public int $unit_id,
        public string $short_hand,
    ) {}

    public static function from_id(int $unit_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $unit_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['unit_id'], $result['short_hand']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Units` (`unit_id`, `short_hand`) VALUES (?, ?)');
        $stmt->bind_param('is', $this->unit_id, $this->short_hand);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Units` SET `short_hand` = ? WHERE `unit_id` = ?');
        $stmt->bind_param('si', $this->short_hand, $this->unit_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->unit_id);
        return $stmt->execute();
    }
}
