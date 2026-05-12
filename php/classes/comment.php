<?php

require_once __DIR__ . '/_classes.php';

class Comment {
    public function __construct(
        public string $id,
        public string $recipe_id,
        public string $user_id,
        public string $body,
        public int $likes,
        public string $created_on,
        public ?string $last_edited,
    ) {}

    public static function from_id(string $id): self {
        $result = get_data_from_id('Comments', $id);

        if (!$result) {
            throw new Exception("Comment not found with id: $id");
        }

        return new self(
            $result['id'],
            $result['recipe_id'],
            $result['user_id'],
            $result['body'],
            $result['likes'],
            $result['created_on'],
            $result['last_edited']
        );
    }
    
    public function create(): void {
        if (empty($this->id) || empty($this->recipe_id) || empty($this->user_id) || empty($this->body) || empty($this->created_on)) {
            throw new Exception("Comment object missing required properties for creation.");
        }
        if (self::is_id_in_use($this->id)) {
            throw new Exception("Cannot create comment. ID '{$this->id}' is already in use.");
        }
        if (!Recipe::is_id_in_use($this->recipe_id) || !User::is_id_in_use($this->user_id)) {
            throw new Exception("Cannot create comment. Recipe or User ID is invalid.");
        }

        global $connection;
        
        $stmt = $connection->prepare("
            INSERT INTO `Comments` (`id`, `recipe_id`, `user_id`, `body`, `likes`, `created_on`)
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('ssssis',
            $this->id,
            $this->recipe_id,
            $this->user_id,
            $this->body,
            $this->likes,
            $this->created_on
        );
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Updates an existing comment record in the database, setting the last_edited time.
     */
    public function update(): void {
        if (empty($this->id) || !self::is_id_in_use($this->id)) {
            throw new Exception("Cannot update comment. ID '{$this->id}' is invalid or not in use.");
        }

        global $connection;
        
        $this->last_edited = date('Y-m-d H:i:s');

        $stmt = $connection->prepare("
            UPDATE `Comments` SET 
                `body` = ?, 
                `likes` = ?, 
                `last_edited` = ?
            WHERE `id` = ?"
        );
        $stmt->bind_param('siss', 
            $this->body, 
            $this->likes, 
            $this->last_edited, 
            $this->id
        );
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Deletes the comment record from the database.
     */
    public function delete(): void {
        if (empty($this->id) || !self::is_id_in_use($this->id)) {
            throw new Exception("Cannot delete comment. ID '{$this->id}' is invalid or not in use.");
        }
        
        global $connection;

        $stmt = $connection->prepare("DELETE FROM `Comments` WHERE `id` = ?");
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        $stmt->close();
    }
    
    public static function get_new_id(): string {
        global $connection;
        
        while (true) {
            $id = random_string(length: 200);
            
            $stmt = $connection->prepare("SELECT `id` FROM `Comments` WHERE `id`=?");
            $stmt->bind_param('s', $id);
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

        $stmt = $connection->prepare("SELECT `id` FROM `Comments` WHERE id=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count === 1;
    }

    public static function get_blank(): self {
        return new self(
            '',
            '',
            '',
            '',
            0,
            '',
            null
        );
    }
}
