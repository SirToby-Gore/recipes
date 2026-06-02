<?php

require_once '_classes.php';

class UnitConversion
{
    public function __construct(
        public string $unit_id_from,
        public string $unit_id_to,
        public float $multiplier,
    ) {}

    public static function from_id(string $unit_id_from, string $unit_id_to): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Unitconversions` WHERE `unit_id_from` = ? AND `unit_id_to` = ?');
        $stmt->bind_param('ss', $unit_id_from, $unit_id_to);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Unitconversions` (`unit_id_from`, `unit_id_to`, `multiplier`) VALUES (?, ?, ?)');
        $stmt->bind_param('ssd', $this->unit_id_from, $this->unit_id_to, $this->multiplier);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Unitconversions` SET `multiplier` = ? WHERE `unit_id_from` = ? AND `unit_id_to` = ?');
        $stmt->bind_param('dss', $this->multiplier, $this->unit_id_from, $this->unit_id_to);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Unitconversions` WHERE `unit_id_from` = ? AND `unit_id_to` = ?');
        $stmt->bind_param('ss', $this->unit_id_from, $this->unit_id_to);
        return $stmt->execute();
    }
}
