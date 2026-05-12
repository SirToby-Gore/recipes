<?php

require_once __DIR__ . '/_classes.php';


class Ingredient_list {
    public function __construct(
        public string $recipe_id,
        public string $ingredient_id,
        public float $amount,
        public int $unit_id,
    ) {}

    public static function from_id(string $recipe_id, string $ingredient_id): self {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Ingredients_list` WHERE `recipe_id`=? AND `ingredient_id`=?");
        $stmt->bind_param('ss', $recipe_id, $ingredient_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            throw new Exception("Ingredient_list item not found for recipe: $recipe_id, ingredient: $ingredient_id");
        }

        return new self(
            $result['recipe_id'],
            $result['ingredient_id'],
            $result['amount'],
            $result['unit_id']
        );
    }
    
    public function create(): void {
        if (empty($this->recipe_id) || empty($this->ingredient_id) || $this->amount === null || $this->unit_id === null) {
            throw new Exception("Ingredient_list object missing required properties for creation.");
        }
        if (self::is_id_in_use($this->recipe_id, $this->ingredient_id)) {
            throw new Exception("Cannot create ingredient list item. Combination (Recipe: {$this->recipe_id}, Ingredient: {$this->ingredient_id}) is already in use.");
        }
        if (!Recipe::is_id_in_use($this->recipe_id) || !Ingredient::is_id_in_use($this->ingredient_id) || !Unit::is_id_in_use($this->unit_id)) {
            throw new Exception("Cannot create ingredient list item. One or more foreign keys are invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Ingredients_list` (`recipe_id`, `ingredient_id`, `amount`, `unit_id`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssdi', $this->recipe_id, $this->ingredient_id, $this->amount, $this->unit_id);
        $stmt->execute();
        $stmt->close();
    }

    public static function is_id_in_use(string $recipe_id, string $ingredient_id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `recipe_id` FROM `Ingredients_list` WHERE `recipe_id`=? AND `ingredient_id`=?");
        $stmt->bind_param('ss', $recipe_id, $ingredient_id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
