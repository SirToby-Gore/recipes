<?php

require_once __DIR__ . '/_classes.php';

class Allergen {
    public function __construct(
        public ?int $id, // Changed to ?int
        public string $name,
        public ?string $description,
    ) {}
    
    public static function from_id(int $id): self {
        $result = get_data_from_id('Allergens', $id);

        if (!$result) {
            throw new Exception("Allergen not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['name'],
            $result['description'],
        );
    }

    public function create(): void {
        if (empty($this->name)) {
            throw new Exception("Allergen object missing required properties (name) for creation.");
        }
        if ($this->id !== null) {
            throw new Exception("Cannot create allergen. ID must be null for new auto-incremented records.");
        }
        
        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Allergens` (`name`, `description`) VALUES (?, ?)");
        $stmt->bind_param('ss', $this->name, $this->description);
        $stmt->execute();
        $stmt->close();

        $this->set_new_id();
    }

    public function set_new_id(): void {
        global $connection;
        $this->id = $connection->insert_id;
    }

    public static function is_id_in_use(int $id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `id` FROM `Allergens` WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
