DROP TABLE IF EXISTS `Likes`;

DROP TABLE IF EXISTS `Comments`;

DROP TABLE IF EXISTS `Substitutions`;

DROP TABLE IF EXISTS `Allergens`;

DROP TABLE IF EXISTS `Allergy`;

DROP TABLE IF EXISTS `Units`;

DROP TABLE IF EXISTS `IngredientsList`;

DROP TABLE IF EXISTS `Ingredients`;

DROP TABLE IF EXISTS `Tags`;

DROP TABLE IF EXISTS `IngredientsUsedInStep`;

DROP TABLE IF EXISTS `Steps`;

DROP TABLE IF EXISTS `Recipes`;

DROP TABLE IF EXISTS `Tokens`;

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
    `user_id` VARCHAR(64) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(10) NOT NULL,
    `created_on` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `Tokens` (
    `token` VARCHAR(200) NOT NULL,
    `user_id` VARCHAR(64) NOT NULL,
    `created_on` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`token`),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Recipes` (
    `recipe_id` VARCHAR(64) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `number_of_steps` INT NOT NULL,
    `total_time` INT NOT NULL,
    `portions` INT NOT NULL,
    `parent` VARCHAR(64),
    `user_id` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`recipe_id`),
    FOREIGN KEY (`parent`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Steps` (
    `step_number` INT AUTO_INCREMENT NOT NULL,
    `recipe_id` VARCHAR(64) NOT NULL,
    `step` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`step_number`, `recipe_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE
);

CREATE TABLE `IngredientsUsedInStep` (
    `step_number` INT AUTO_INCREMENT NOT NULL,
    `recipe_id` VARCHAR(64) NOT NULL,
    `ingredient_id` VARCHAR(64) NOT NULL,
    `amount` DECIMAL(15,4) NOT NULL,
    `unit` INT NOT NULL,
    PRIMARY KEY (`step_number`, `recipe_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Tags` (
    `recipe_id` VARCHAR(64) NOT NULL,
    `tag_name` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`recipe_id`, `tag_name`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE
);

CREATE TABLE `Ingredients` (
    `ingredient_id` VARCHAR(64) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`)
);

CREATE TABLE `IngredientsList` (
    `recipe_id` VARCHAR(64) NOT NULL,
    `ingredient_id` VARCHAR(64) NOT NULL,
    `amount` DECIMAL(15,4) NOT NULL,
    `unit_id` INT NOT NULL,
    PRIMARY KEY (`recipe_id`, `ingredient_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit_id`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Units` (
    `unit_id` INT AUTO_INCREMENT NOT NULL,
    `short_hand` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`unit_id`)
);

CREATE TABLE `Allergy` (
    `ingredient_id` VARCHAR(64) NOT NULL,
    `allergen_id` INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (`ingredient_id`, `allergen_id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`allergen_id`) REFERENCES `Allergens`(`allergen_id`) ON DELETE CASCADE
);

CREATE TABLE `Allergens` (
    `allergen_id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`allergen_id`)
);

CREATE TABLE `Substitutions` (
    `ingredient_id` VARCHAR(64) NOT NULL,
    `substitution_id` VARCHAR(64) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`, `substitution_id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`substitution_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE
);

CREATE TABLE `Comments` (
    `comment_id` VARCHAR(100) NOT NULL,
    `recipe_id` VARCHAR(64) NOT NULL,
    `user_id` VARCHAR(64) NOT NULL,
    `created_on` VARCHAR(255) NOT NULL,
    `body` VARCHAR(255) NOT NULL,
    `last_edited` VARCHAR(255),
    PRIMARY KEY (`comment_id`, `recipe_id`, `user_id`, `created_on`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Likes` (
    `recipe_id` VARCHAR(64) NOT NULL,
    `comment_id` VARCHAR(100) NOT NULL,
    `user_id` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`recipe_id`, `comment_id`, `user_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`comment_id`) REFERENCES `Comments`(`comment_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);