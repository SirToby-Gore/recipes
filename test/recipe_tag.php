<?php

require_once '_classes.php';

class RecipeTag
{
    public function __construct(
        public string $recipe_id,
        public string $tag_id,
    ) {}

    public static function from_id(string $recipe_id, string $tag_id): ?self
    {
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `Recipetags` WHERE `recipe_id` = ? AND `tag_id` = ?');
        $stmt->bind_param('ss', $recipe_id, $tag_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? new self(...$result) : null;
    }

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Recipetags` (`recipe_id`, `tag_id`) VALUES (?, ?)');
        $stmt->bind_param('ss', $this->recipe_id, $this->tag_id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        global $conn;
        $stmt = $conn->prepare('UPDATE `Recipetags` SET  WHERE `recipe_id` = ? AND `tag_id` = ?');
        $stmt->bind_param('ss', , $this->recipe_id, $this->tag_id);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        global $conn;
        $stmt = $conn->prepare('DELETE FROM `Recipetags` WHERE `recipe_id` = ? AND `tag_id` = ?');
        $stmt->bind_param('ss', $this->recipe_id, $this->tag_id);
        return $stmt->execute();
    }
}
