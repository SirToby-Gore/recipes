<?php

require_once __DIR__ . '/_classes.php';

class User {
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $password_hash,
        public string $salt,
        public string $created_on,
    ) {}

    public static function get_blank(): self {
        return new self(
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }

    public static function from_id(string $id): self {
        $result = get_data_from_id('Users', $id);

        if (!$result) {
            throw new Exception("User not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['name'],
            $result['email'],
            $result['password_hash'],
            $result['salt'],
            $result['created_on']
        );
    }

    public function create(): void {
        if (empty($this->id) || empty($this->name) || empty($this->email) || empty($this->password_hash) || empty($this->salt)) {
            throw new Exception("User object missing required properties for creation.");
        }
        if (self::is_id_in_use($this->id)) {
            throw new Exception("Cannot create user. ID '{$this->id}' is already in use.");
        }

        global $connection;
        
        $stmt = $connection->prepare("
            INSERT INTO `Users` (`id`, `name`, `email`, `password_hash`, `salt`)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssss',
            $this->id,
            $this->name,
            $this->email,
            $this->password_hash,
            $this->salt
        );
        $stmt->execute();
        $stmt->close();
    }
    
    public function add_recipe(Recipe $recipe): void {
        // Enforce the relationship: a user can only add a recipe they own.
        if ($recipe->user_id !== $this->id) {
            throw new Exception("Recipe must belong to this user to be added.");
        }
        $recipe->create();
    }

    public function hash_password(string $password): string {
        return hash(algo: 'sha256', data: $password . $this->salt);
    }

    public function add_password(string $password): void {
        $this->password_hash = $this->hash_password($password);
    }

    public function is_password_correct(string $password): bool {
        return $this->password_hash == $this->hash_password($password);
    }
    
    public static function is_email_taken(string $email): bool {
        global $connection;
        
        $stmt = $connection->prepare("SELECT COUNT(`email`) FROM `Users` WHERE `email`=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_row()[0];
        $stmt->close();
        
        return $count > 0;
    }

    public static function get_new_id(): string {
        global $connection;
        
        while (true) {
            $id = random_string(length: 100);
            
            $stmt = $connection->prepare("SELECT `id` FROM `Users` WHERE `id`=?");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($result->num_rows === 0) {
                return $id;
            }
        }
    }

    public static function get_new_salt(): string {
        return random_string(10);
    }

    public function get_recipes(): array {
        global $connection;

        $stmt = $connection->prepare("SELECT `id` FROM `Recipes` WHERE `user_id`=?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all();

        $recipes = [];
        
        foreach ($result as $row) {
            $recipes[] = Recipe::from_id($row[0]);
        }

        return $recipes;
    }

    public static function is_id_in_use(string $id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `id` FROM `Users` WHERE id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
