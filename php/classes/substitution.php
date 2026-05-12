<?php

require_once __DIR__ . '/_classes.php';

class Substitution {
    public function __construct(
        public string $parent_ingredient_id,
        public string $substitution_id,
        public ?string $description,
    ) {}
    
    public static function from_id(string $parent_ingredient_id, string $substitution_id): self {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Substitutions` WHERE `parent_ingredient_id`=? AND `substitution_id`=?");
        $stmt->bind_param('ss', $parent_ingredient_id, $substitution_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            throw new Exception("Substitution not found between $parent_ingredient_id and $substitution_id");
        }

        return new self(
            $result['parent_ingredient_id'],
            $result['substitution_id'],
            $result['description']
        );
    }
    
    public function create(): void {
        if (empty($this->parent_ingredient_id) || empty($this->substitution_id)) {
            throw new Exception("Substitution object missing required properties for creation.");
        }
        if (self::is_id_in_use($this->parent_ingredient_id, $this->substitution_id)) {
            throw new Exception("Cannot create substitution. Combination (Parent: {$this->parent_ingredient_id}, Sub: {$this->substitution_id}) is already in use.");
        }
        if (!Ingredient::is_id_in_use($this->parent_ingredient_id) || !Ingredient::is_id_in_use($this->substitution_id)) {
            throw new Exception("Cannot create substitution. One or more ingredient IDs are invalid.");
        }
        if ($this->parent_ingredient_id === $this->substitution_id) {
            throw new Exception("Parent ingredient cannot be the same as the substitute ingredient.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Substitutions` (`parent_ingredient_id`, `substitution_id`, `description`) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $this->parent_ingredient_id, $this->substitution_id, $this->description);
        $stmt->execute();
        $stmt->close();
    }
    
    public static function is_id_in_use(string $parent_ingredient_id, string $substitution_id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `parent_ingredient_id` FROM `Substitutions` WHERE `parent_ingredient_id`=? AND `substitution_id`=?");
        $stmt->bind_param('ss', $parent_ingredient_id, $substitution_id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
