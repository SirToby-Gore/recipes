<?php

require_once '_classes.php';

class CompatibleUnit
{
    public function __construct(
        public int $base_unit,
        public int $new_unit,
        public float $multiplier,
    ) {}

    public static function from_id(int $base_unit, int $new_unit): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CompatibleUnits` WHERE `base_unit` = ? AND `new_unit` = ?');
        $stmt->bind_param('ii', $base_unit, $new_unit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new self($result['base_unit'], $result['new_unit'], $result['multiplier']);
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `CompatibleUnits` (`base_unit`, `new_unit`, `multiplier`) VALUES (?, ?, ?)');
        $stmt->bind_param('iid', $this->base_unit, $this->new_unit, $this->multiplier);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `CompatibleUnits` SET `multiplier` = ? WHERE `base_unit` = ? AND `new_unit` = ?');
        $stmt->bind_param('dii', $this->multiplier, $this->base_unit, $this->new_unit);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `CompatibleUnits` WHERE `base_unit` = ? AND `new_unit` = ?');
        $stmt->bind_param('ii', $this->base_unit, $this->new_unit);
        return $stmt->execute();
    }

    public function get_base_unit(): ?Unit
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->base_unit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Unit($result['unit_id'], $result['short_hand']);
    }

    public function get_new_unit(): ?Unit
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Units` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->new_unit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) return null;
        return new Unit($result['unit_id'], $result['short_hand']);
    }
}
