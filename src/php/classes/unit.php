<?php

require_once __DIR__ . '/_classes.php';

class Unit {
    public function __construct(
        public ?int $id, // Changed to ?int
        public string $short_hand,
    ) {}

    public static function from_id(int $id): self {
        $result = get_data_from_id('Units', $id);

        if (!$result) {
            throw new Exception("Unit not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['short_hand']
        );
    }

    public function create(): void {
        if (empty($this->short_hand)) {
            throw new Exception("Unit object missing required properties (short_hand) for creation.");
        }
        if ($this->id !== null) {
            throw new Exception("Cannot create unit. ID must be null for new auto-incremented records.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Units` (`short_hand`) VALUES (?)");
        $stmt->bind_param('s', $this->short_hand);
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

        $stmt = $connection->prepare("SELECT `id` FROM `Units` WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
