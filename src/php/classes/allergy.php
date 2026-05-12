<?php

require_once __DIR__ . '/_classes.php';

class Allergy {
    public function __construct(
        public string $ingredient_id,
        public int $allergen_id,
    ) {}

    public static function from_id(string $ingredient_id, int $allergen_id): self {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Allergy` WHERE `ingredient_id`=? AND `allergen_id`=?");
        $stmt->bind_param('si', $ingredient_id, $allergen_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            throw new Exception("Allergy not found for ingredient: $ingredient_id, allergen: $allergen_id");
        }

        return new self(
            $result['ingredient_id'],
            $result['allergen_id']
        );
    }
    
    public function create(): void {
        if (empty($this->ingredient_id) || $this->allergen_id === null) {
            throw new Exception("Allergy object missing required properties for creation.");
        }
        if (self::is_id_in_use($this->ingredient_id, $this->allergen_id)) {
            throw new Exception("Cannot create allergy. Combination (Ingredient: {$this->ingredient_id}, Allergen: {$this->allergen_id}) is already in use.");
        }
        if (!Ingredient::is_id_in_use($this->ingredient_id) || !Allergen::is_id_in_use($this->allergen_id)) {
            throw new Exception("Cannot create allergy. One or more foreign keys are invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Allergy` (`ingredient_id`, `allergen_id`) VALUES (?, ?)");
        $stmt->bind_param('si', $this->ingredient_id, $this->allergen_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function is_id_in_use(string $ingredient_id, int $allergen_id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `ingredient_id` FROM `Allergy` WHERE `ingredient_id`=? AND `allergen_id`=?");
        $stmt->bind_param('si', $ingredient_id, $allergen_id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
