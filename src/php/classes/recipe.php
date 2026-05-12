<?php

require_once __DIR__ . '/_classes.php';


class Recipe {
    public function __construct(
        public string $id,
        public string $title,
        public ?string $description,
        public ?int $number_of_steps,
        public int $total_time_minutes,
        public int $portions,
        public ?string $parent_id,
        public string $user_id,
    ) {}

    public static function from_id(string $id): self {
        $result = get_data_from_id('Recipes', $id);

        if (!$result) {
            throw new Exception("Recipe not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['title'],
            $result['description'],
            $result['number_of_steps'],
            $result['total_time_minutes'],
            $result['portions'],
            $result['parent_id'],
            $result['user_id']
        );
    }

    public function create(): void {
        if (empty($this->id) || empty($this->title) || empty($this->user_id) || $this->total_time_minutes === null || $this->portions === null) {
            throw new Exception("Recipe object missing required properties (id, title, user_id, time, portions) for creation.");
        }
        if (self::is_id_in_use($this->id)) {
            throw new Exception("Cannot create recipe. ID '{$this->id}' is already in use.");
        }
        if (!User::is_id_in_use($this->user_id)) {
            throw new Exception("Cannot create recipe. User ID '{$this->user_id}' is invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("
            INSERT INTO `Recipes` (`id`, `title`, `description`, `number_of_steps`, `total_time_minutes`, `portions`, `parent_id`, `user_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssiiiss', 
            $this->id, 
            $this->title, 
            $this->description, 
            $this->number_of_steps, 
            $this->total_time_minutes, 
            $this->portions, 
            $this->parent_id, 
            $this->user_id
        );
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Updates an existing recipe record in the database.
     */
    public function update(): void {
        if (empty($this->id) || !self::is_id_in_use($this->id)) {
            throw new Exception("Cannot update recipe. ID '{$this->id}' is invalid or not in use.");
        }
        
        global $connection;

        $stmt = $connection->prepare("
            UPDATE `Recipes` SET 
                `title` = ?, 
                `description` = ?, 
                `number_of_steps` = ?, 
                `total_time_minutes` = ?, 
                `portions` = ?, 
                `parent_id` = ?
            WHERE `id` = ?"
        );
        $stmt->bind_param('ssiiiss', 
            $this->title, 
            $this->description, 
            $this->number_of_steps, 
            $this->total_time_minutes, 
            $this->portions, 
            $this->parent_id, 
            $this->id
        );
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Deletes the recipe record from the database.
     * Note: Deleting a recipe will usually cascade (delete) all related steps, 
     * ingredient list items, and comments if your database is set up with ON DELETE CASCADE.
     */
    public function delete(): void {
        if (empty($this->id) || !self::is_id_in_use($this->id)) {
            throw new Exception("Cannot delete recipe. ID '{$this->id}' is invalid or not in use.");
        }
        
        global $connection;

        $stmt = $connection->prepare("DELETE FROM `Recipes` WHERE `id` = ?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public static function get_new_id(): string {
        global $connection;

        while (true) {
            $id = random_string(length: 100);

            $stmt = $connection->prepare("SELECT `id` FROM `Recipes` WHERE `id`=?");
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

        $stmt = $connection->prepare("SELECT `id` FROM `Recipes` WHERE id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count === 1;
    }

    public function get_ingredients(): array {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Ingredients_list` WHERE `recipe_id`=?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        
        $ingredients = [];
        
        foreach ($stmt->get_result()->fetch_all() as $row) {
            $ingredients[] = new Ingredient_list(
                $row[0],
                $row[1],
                $row[2],
                $row[3],
            );
        }

        return $ingredients;
    }
    
    public function get_steps(): array {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Steps` WHERE `recipe_id`=?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all();

        $steps = [];

        foreach ($result as $step) {
            $steps[] = new Step(
                $step[0],
                $step[1],
                $step[2],
            );
        }

        usort($steps, function ($a, $b) {
            return $a->step_number <=> $b->step_number;
        });

        return $steps;
    }

    public function get_comments(): array {
        global $connection;

        $stmt = $connection->prepare("SELECT `id` FROM `Comments` WHERE `recipe_id`=? ORDER BY `likes` DESC");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        
        $comments = [];
        foreach ($stmt->get_result()->fetch_all() as $row) {
            $comments[] = Comment::from_id($row[0]);
        }

        return $comments;
    }

    public function get_tags(): array {
        global $connection;
        
        $stmt = $connection->prepare("SELECT `tag_name` FROM `Tags` WHERE `recipe_id`=?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        
        $tags = [];
        foreach ($stmt->get_result()->fetch_all() as $row) {
            $tags[] = new Tag($this->id, $row[0]);
        }
        
        return $tags;
    }

    public static function get_all(): array {
        global $connection;

        $result = $connection->query("SELECT * FROM `Recipes`");

        $recipes = [];

        foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
            $recipes[] = new self(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['number_of_steps'],
                $row['total_time_minutes'],
                $row['portions'],
                $row['parent_id'],
                $row['user_id']
            );
        }

        return $recipes;
    }
    
    public static function get_blank(): self {
        return new self(
            '',
            '',
            null,
            null,
            0,
            0,
            null,
            '',
        );
    }
}
