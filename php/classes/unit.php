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

    public function get_compatible_units_by_base_unit(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CompatibleUnits` WHERE `base_unit` = ?');
        $stmt->bind_param('i', $this->unit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new CompatibleUnit($row['base_unit'], $row['new_unit'], $row['multiplier']);
        }
        return $items;
    }

    public function get_compatible_units_by_new_unit(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `CompatibleUnits` WHERE `new_unit` = ?');
        $stmt->bind_param('i', $this->unit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new CompatibleUnit($row['base_unit'], $row['new_unit'], $row['multiplier']);
        }
        return $items;
    }

    public function get_ingredients_used_in_steps(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `IngredientsUsedInSteps` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->unit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new IngredientsUsedInStep($row['step_id'], $row['ingredient_id'], $row['amount'], $row['unit_id']);
        }
        return $items;
    }

    public function get_shopping_list_items(): array
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `ShoppingListItems` WHERE `unit_id` = ?');
        $stmt->bind_param('i', $this->unit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new ShoppingListItem($row['user_id'], $row['ingredient_id'], $row['recipe_id'], $row['amount'], $row['unit_id'], $row['is_checked']);
        }
        return $items;
    }
}
