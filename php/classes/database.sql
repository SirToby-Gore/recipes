DROP TABLE IF EXISTS `ShoppingListItems`;

DROP TABLE IF EXISTS `CommentLikes`;

DROP TABLE IF EXISTS `Comments`;

DROP TABLE IF EXISTS `Substitutions`;

DROP TABLE IF EXISTS `Allergies`;

DROP TABLE IF EXISTS `Allergens`;

DROP TABLE IF EXISTS `IngredientsUsedInSteps`;

DROP TABLE IF EXISTS `Ingredients`;

DROP TABLE IF EXISTS `Tags`;

DROP TABLE IF EXISTS `Steps`;

DROP TABLE IF EXISTS `RecipeFavourites`;

DROP TABLE IF EXISTS `RecipeLikes`;

DROP TABLE IF EXISTS `Baskets`;

DROP TABLE IF EXISTS `Recipes`;

DROP TABLE IF EXISTS `CompatibleUnits`;

DROP TABLE IF EXISTS `Units`;

DROP TABLE IF EXISTS `Tokens`;

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
    `user_id` VARCHAR(32) NOT NULL,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `salt` VARCHAR(32) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_on` DATETIME NOT NULL,
    PRIMARY KEY (`user_id`)
);

CREATE TABLE `Tokens` (
    `token` VARCHAR(64) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    `created_on` DATETIME NOT NULL,
    PRIMARY KEY (`token`),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Units` (
    `unit_id` INT NOT NULL,
    `short_hand` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`unit_id`)
);

CREATE TABLE `CompatibleUnits` (
    `base_unit` INT NOT NULL,
    `new_unit` INT NOT NULL,
    `multiplier` DECIMAL(15,4) NOT NULL,
    PRIMARY KEY (`base_unit`, `new_unit`),
    FOREIGN KEY (`base_unit`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE,
    FOREIGN KEY (`new_unit`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Recipes` (
    `recipe_id` VARCHAR(32) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `total_time` INT NOT NULL,
    `portions` INT NOT NULL,
    `parent` VARCHAR(32),
    `user_id` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`recipe_id`),
    FOREIGN KEY (`parent`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Baskets` (
    `recipe_id` VARCHAR(32) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    `amount` INT NOT NULL,
    PRIMARY KEY (`recipe_id`, `user_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `RecipeLikes` (
    `recipe_id` VARCHAR(32) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`recipe_id`, `user_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `RecipeFavourites` (
    `recipe_id` VARCHAR(32) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`recipe_id`, `user_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `Steps` (
    `step_id` VARCHAR(38) NOT NULL,
    `step_number` INT NOT NULL,
    `recipe_id` VARCHAR(32) NOT NULL,
    `step` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`step_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE
);

CREATE TABLE `Tags` (
    `recipe_id` VARCHAR(32) NOT NULL,
    `tag_name` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`recipe_id`, `tag_name`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE
);

CREATE TABLE `Ingredients` (
    `ingredient_id` VARCHAR(32) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `category` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`ingredient_id`)
);

CREATE TABLE `IngredientsUsedInSteps` (
    `step_id` VARCHAR(38) NOT NULL,
    `ingredient_id` VARCHAR(32) NOT NULL,
    `amount` DECIMAL(15,4) NOT NULL,
    `unit_id` INT NOT NULL,
    PRIMARY KEY (`step_id`, `ingredient_id`),
    FOREIGN KEY (`step_id`) REFERENCES `Steps`(`step_id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit_id`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);

CREATE TABLE `Allergens` (
    `allergen_id` INT NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`allergen_id`)
);

CREATE TABLE `Allergies` (
    `ingredient_id` VARCHAR(32) NOT NULL,
    `allergen_id` INT NOT NULL,
    PRIMARY KEY (`ingredient_id`, `allergen_id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`allergen_id`) REFERENCES `Allergens`(`allergen_id`) ON DELETE CASCADE
);

CREATE TABLE `Substitutions` (
    `ingredient_id` VARCHAR(32) NOT NULL,
    `substitution_id` VARCHAR(32) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ingredient_id`, `substitution_id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`substitution_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE
);

CREATE TABLE `Comments` (
    `comment_id` VARCHAR(38) NOT NULL,
    `recipe_id` VARCHAR(32) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    `created_on` DATETIME NOT NULL,
    `body` VARCHAR(255) NOT NULL,
    `last_edited` DATETIME,
    PRIMARY KEY (`comment_id`),
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `CommentLikes` (
    `comment_id` VARCHAR(38) NOT NULL,
    `user_id` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`comment_id`, `user_id`),
    FOREIGN KEY (`comment_id`) REFERENCES `Comments`(`comment_id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE
);

CREATE TABLE `ShoppingListItems` (
    `user_id` VARCHAR(32) NOT NULL,
    `ingredient_id` VARCHAR(32) NOT NULL,
    `recipe_id` VARCHAR(32),
    `amount` DECIMAL(15,4) NOT NULL,
    `unit_id` INT NOT NULL,
    `is_checked` TINYINT(1) NOT NULL,
    PRIMARY KEY (`user_id`, `ingredient_id`),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `Ingredients`(`ingredient_id`) ON DELETE CASCADE,
    FOREIGN KEY (`recipe_id`) REFERENCES `Recipes`(`recipe_id`) ON DELETE CASCADE,
    FOREIGN KEY (`unit_id`) REFERENCES `Units`(`unit_id`) ON DELETE CASCADE
);