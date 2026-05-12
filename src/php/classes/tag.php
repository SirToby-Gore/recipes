<?php

require_once __DIR__ . '/_classes.php';


class Tag {
    public function __construct(
        public string $recipe_id,
        public string $tag_name,
    ) {}

    public static function from_id(string $recipe_id, string $tag_name): self {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `Tags` WHERE `recipe_id`=? AND `tag_name`=?");
        $stmt->bind_param('ss', $recipe_id, $tag_name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$result) {
            throw new Exception("Tag not found for recipe: $recipe_id, tag: $tag_name");
        }

        return new self(
            $result['recipe_id'],
            $result['tag_name']
        );
    }
    
    public function create(): void {
        if (empty($this->recipe_id) || empty($this->tag_name)) {
            throw new Exception("Tag object missing required properties (recipe_id, tag_name) for creation.");
        }
        if (self::is_id_in_use($this->recipe_id, $this->tag_name)) {
            throw new Exception("Cannot create tag. Combination (Recipe: {$this->recipe_id}, Tag: {$this->tag_name}) is already in use.");
        }
        if (!Recipe::is_id_in_use($this->recipe_id)) {
            throw new Exception("Cannot create tag. Recipe ID '{$this->recipe_id}' is invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Tags` (`recipe_id`, `tag_name`) VALUES (?, ?)");
        $stmt->bind_param('ss', $this->recipe_id, $this->tag_name);
        $stmt->execute();
        $stmt->close();
    }

    public static function is_id_in_use(string $recipe_id, string $tag_name): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `recipe_id` FROM `Tags` WHERE `recipe_id`=? AND `tag_name`=?");
        $stmt->bind_param('ss', $recipe_id, $tag_name);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
}
