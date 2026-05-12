<?php

require_once __DIR__ . '/_classes.php';

class Step {
    public function __construct(
        public string $recipe_id,
        public int $step_number,
        public string $step,
    ) {}

    public static function from_id(string $recipe_id, int $step_number): self {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Steps` WHERE `recipe_id`=? AND `step_number`=?");
        $stmt->bind_param('si', $recipe_id, $step_number);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            throw new Exception("Step not found for recipe: $recipe_id, number: $step_number");
        }

        return new self(
            $result['recipe_id'],
            $result['step_number'],
            $result['step']
        );
    }
    
    public function create(): void {
        if (empty($this->recipe_id) || empty($this->step) || $this->step_number === null) {
            throw new Exception("Step object missing required properties (recipe_id, step_number, step) for creation.");
        }
        if (self::is_id_in_use($this->recipe_id, $this->step_number)) {
            throw new Exception("Cannot create step. Combination (Recipe: {$this->recipe_id}, Step#: {$this->step_number}) is already in use.");
        }
        if (!Recipe::is_id_in_use($this->recipe_id)) {
            throw new Exception("Cannot create step. Recipe ID '{$this->recipe_id}' is invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Steps` (`recipe_id`, `step_number`, `step`) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $this->recipe_id, $this->step_number, $this->step);
        $stmt->execute();
        $stmt->close();
    }
    
    public static function is_id_in_use(string $recipe_id, int $step_number): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `recipe_id` FROM `Steps` WHERE `recipe_id`=? AND `step_number`=?");
        $stmt->bind_param('si', $recipe_id, $step_number);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
