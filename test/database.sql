CREATE DATABASE IF NOT EXISTS `test`;

USE `test`;

CREATE TABLE `Users` (
    `user_id` VARCHAR(64) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(10) NOT NULL,
    `created_on` DATETIME NOT NULL,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `Tokens` (
    `token` VARCHAR(128) NOT NULL,
    `user_id` VARCHAR(255) NOT NULL,
    `created_on` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Recipes` (
    `recipe_id` VARCHAR(64) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `number_of_steps` INT NOT NULL,
    `total_time` INT NOT NULL,
    `portions` INT NOT NULL,
    `parent_id` VARCHAR(255),
    `user_id` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`recipe_id`),
    FOREIGN KEY (`parent_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Steps` (
    `step_number` VARCHAR(2) NOT NULL,
    `recipe_id` VARCHAR(255) NOT NULL,
    `step` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`step_number`, `recipe_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE
);

CREATE TABLE `RecipeTags` (
    `recipe_id` VARCHAR(255) NOT NULL,
    `tag_id` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`recipe_id`, `tag_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tag_id`) REFERENCES `Tags`(`tag_id`) ON DELETE CASCADE
);

CREATE TABLE `Tags` (
    `tag_id` VARCHAR(64) NOT NULL,
    `name` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`tag_id`)
);

CREATE TABLE `Ingredients` (
    `ingredient_id` VARCHAR(128) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`)
);

CREATE TABLE `IngredientsList` (
    `recipe_id` VARCHAR(255) NOT NULL,
    `ingredient_id` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(15,4) NOT NULL,
    `unit_id` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`recipe_id`, `ingredient_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit_id`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Units` (
    `unit_id` VARCHAR(16) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `short_hand` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`unit_id`)
);

CREATE TABLE `UnitConversions` (
    `unit_id_from` VARCHAR(255) NOT NULL,
    `unit_id_to` VARCHAR(255) NOT NULL,
    `multiplier` DECIMAL(15,4) NOT NULL,
    PRIMARY KEY (`unit_id_from`, `unit_id_to`),
    FOREIGN KEY (`unit_id_from`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit_id_to`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Allergy` (
    `ingredient_id` VARCHAR(255) NOT NULL,
    `allergen` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`, `allergen`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`allergen`) REFERENCES `Allergens`(`allergen_id`) ON DELETE CASCADE
);

CREATE TABLE `Allergens` (
    `allergen_id` VARCHAR(16) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`allergen_id`)
);

CREATE TABLE `Substitutions` (
    `ingredient_id` VARCHAR(255) NOT NULL,
    `substitution_id` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`, `substitution_id`)
);

CREATE TABLE `Comments` (
    `comment_id` VARCHAR(16) NOT NULL,
    `recipe_id` VARCHAR(255) NOT NULL,
    `body` VARCHAR(255) NOT NULL,
    `user_id` VARCHAR(255) NOT NULL,
    `created_on` DATETIME NOT NULL,
    PRIMARY KEY (`comment_id`, `recipe_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Likes` (
    `comment_id` VARCHAR(255) NOT NULL,
    `recipe_id` VARCHAR(255) NOT NULL,
    `user_id` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`comment_id`, `recipe_id`, `user_id`),
    FOREIGN KEY (`comment_id`) REFERENCES `Comments`(`comment_id`) ON DELETE CASCADE,
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);