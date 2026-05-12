-- -----------------------------------------------------
-- Core Entities
-- -----------------------------------------------------

-- Users Table
CREATE TABLE Users (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL COMMENT 'Uses SHA-255',
    salt VARCHAR(10) NOT NULL,
    created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Recipes Table
CREATE TABLE Recipes (
    id VARCHAR(100) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    number_of_steps INTEGER,
    total_time_minutes INTEGER,
    portions INTEGER,
    parent_id VARCHAR(100), -- Used for recipe variants
    user_id VARCHAR(100) NOT NULL,
    
    FOREIGN KEY (parent_id) REFERENCES Recipes(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Ingredients Table
CREATE TABLE Ingredients (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT
);

-- Lookup Tables
CREATE TABLE Units (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, -- Using AUTO_INCREMENT for lookup tables
    short_hand VARCHAR(10) UNIQUE NOT NULL
);

CREATE TABLE Allergens (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, -- Using AUTO_INCREMENT for lookup tables
    name VARCHAR(255) NOT NULL,
    description TEXT
);

-- -----------------------------------------------------
-- Supporting & Dependent Tables
-- -----------------------------------------------------

-- Tokens Table (for authentication)
CREATE TABLE Tokens (
    token VARCHAR(200) PRIMARY KEY,
    user_id VARCHAR(100) NOT NULL,
    created_on DATE NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Delete after 24hr',
    
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Steps Table (Composite PK: recipe_id, step_number)
CREATE TABLE Steps (
    recipe_id VARCHAR(100) NOT NULL,
    step_number INTEGER NOT NULL,
    step TEXT NOT NULL,
    
    PRIMARY KEY (recipe_id, step_number),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id)
);

-- Tags Table (Composite PK: recipe_id, tag_name)
CREATE TABLE Tags (
    recipe_id VARCHAR(100) NOT NULL,
    tag_name VARCHAR(100) NOT NULL,
    
    PRIMARY KEY (recipe_id, tag_name),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id)
);

-- Ingredients List (Recipe-Ingredient Junction Table)
CREATE TABLE Ingredients_list (
    recipe_id VARCHAR(100) NOT NULL,
    ingredient_id VARCHAR(100) NOT NULL,
    amount DOUBLE PRECISION,
    unit_id INTEGER,
    
    PRIMARY KEY (recipe_id, ingredient_id),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id),
    FOREIGN KEY (ingredient_id) REFERENCES Ingredients(id),
    FOREIGN KEY (unit_id) REFERENCES Units(id)
);

-- Allergy Table (Ingredient-Allergen Junction Table)
CREATE TABLE Allergy (
    ingredient_id VARCHAR(100) NOT NULL,
    allergen_id INTEGER NOT NULL,
    
    PRIMARY KEY (ingredient_id, allergen_id),
    FOREIGN KEY (ingredient_id) REFERENCES Ingredients(id),
    FOREIGN KEY (allergen_id) REFERENCES Allergens(id)
);

-- Substitutions Table (Ingredient-Ingredient Relationship)
CREATE TABLE Substitutions (
    parent_ingredient_id VARCHAR(100) NOT NULL COMMENT 'The ingredient being substituted',
    substitution_id VARCHAR(100) NOT NULL COMMENT 'The substitution ingredient',
    description TEXT,
    
    PRIMARY KEY (parent_ingredient_id, substitution_id),
    FOREIGN KEY (parent_ingredient_id) REFERENCES Ingredients(id),
    FOREIGN KEY (substitution_id) REFERENCES Ingredients(id)
);

-- Comment Table
CREATE TABLE Comment (
    -- Assuming this table should have its own ID, though not specified, 
    -- as a comment can be edited, liked, and easily referenced.
    id VARCHAR(200) PRIMARY KEY, 
    recipe_id VARCHAR(100) NOT NULL,
    user_id VARCHAR(100) NOT NULL,
    body TEXT NOT NULL,
    likes INTEGER DEFAULT 0,
    created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_edited DATETIME,
    
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);