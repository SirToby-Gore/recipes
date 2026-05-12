<?php

require_once __DIR__ . '/_classes.php';

class Ingredient {
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
    ) {}
    
    public static function from_id(string $id): self {
        $result = get_data_from_id('Ingredients', $id);

        if (!$result) {
            throw new Exception("Ingredient not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['name'],
            $result['description'],
        );
    }

    public function create(): void {
        if (empty($this->id) || empty($this->name)) {
            throw new Exception("Ingredient object missing required properties (id, name) for creation.");
        }
        if (self::is_id_in_use($this->id)) {
            throw new Exception("Cannot create ingredient. ID '{$this->id}' is already in use.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Ingredients` (`id`, `name`, `description`) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $this->id, $this->name, $this->description);
        $stmt->execute();
        $stmt->close();
    }
    
    public function add_allergy(Allergy $allergy): void {
        if ($allergy->ingredient_id !== $this->id) {
            throw new Exception("Allergy must reference this ingredient.");
        }
        $allergy->create();
    }
    
    public function add_substitution(Substitution $substitution): void {
        if ($substitution->parent_ingredient_id !== $this->id) {
            throw new Exception("Substitution must use this ingredient as the parent.");
        }
        $substitution->create();
    }
    
    public function add_substitution_as_parent(Substitution $substitution): void {
        if ($substitution->substitution_id !== $this->id) {
            throw new Exception("Substitution must use this ingredient as the substitution.");
        }
        $substitution->create();
    }

    public static function get_new_id(): string {
        global $connection;

        while (true) {
            $id = random_string(length: 100);

            $stmt = $connection->prepare("SELECT `id` FROM `Ingredients` WHERE `id`=?");
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($result->num_rows === 0) {
                return $id;
            }
        }
    }
    
    public static function is_id_in_use(string $id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `id` FROM `Ingredients` WHERE id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
