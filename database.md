```long_uuid
 (string:38)
```

```uuid
 (string:32)
```

# Users

> [liked_tags] user_id -> RecipeLikes.user_id > RecipeLikes.recipe_id -> Tags.recipe_id
> [favourite_tags] user_id -> RecipeFavourites.user_id > RecipeFavourites.recipe_id -> Tags.recipe_id
> [favourite_recipes] user_id -> RecipeFavourites.user_id > RecipeFavourites.recipe_id -> Recipes.recipe_id

- user_id %uuid%

* username (string:100) unique
* email (string:150) unique
* salt (string:32)
* password_hash (string:255) // Secure modern hashing algorithm (e.g., Argon2id/Bcrypt) handled natively via PHP
* created_on (datetime)
* unit_preference (string: 10)

# Tokens

- token (string:64) // Store SHA-256 hash of the session/reset token rather than plain text

* user_id -> Users.user_id
* created_on (datetime) // automatic cron cleanup after 24hr

# Units

- unit_id (int)

* short_hand (string:20) // e.g., 'g', 'ml', 'tbsp'

# CompatibleUnits

- base_unit -> Units.unit_id
- new_unit -> Units.unit_id

* multiplier (float)

# Recipes (Recipe)

> recipe_id -> Steps.recipe_id \
> Steps.step_id -> IngredientsUsedInSteps.step_id \
> IngredientsUsedInSteps.ingredient_id -> Allergies.ingredient_id \
> Allergies.allergen_id -> Allergens.allergen_id

> [ingredients_list] recipe_id -> Steps.recipe_id > Steps.step_id -> IngredientsUsedInSteps.step_id

> [like_count] (count) recipe_id -> RecipeLikes.recipe_id
> [favourite_count] (count) recipe_id -> RecipeFavourites.recipe_id

- recipe_id %uuid%

* title (string:100)
* description (string)
* total_time (int) // represented in minutes
* portions (int)
* parent -> Recipes.recipe_id? // Nullable self-reference used for recipe variants/forks
* user_id -> Users.user_id

# Baskets

- recipe_id -> Recipes.recipe_id
- user_id -> Users.user_id

* amount (int)

# RecipeLikes (RecipeLike)

- recipe_id -> Recipes.recipe_id
- user_id -> Users.user_id

# RecipeFavourites (RecipeFavourite)

- recipe_id -> Recipes.recipe_id
- user_id -> Users.user_id

# Steps

- step_id %long_uuid%

* step_number (int) // index positioning of step, e.g., 1, 2, 3
* recipe_id -> Recipes.recipe_id
* step (string)

# Tags

- recipe_id -> Recipes.recipe_id
- tag_name (string:20)

# Ingredients

> ingredient_id -> IngredientsUsedInSteps.ingredient_id \
> IngredientsUsedInSteps.step_id -> Steps.step_id \
> Steps.recipe_id -> Recipes.recipe_id

- ingredient_id %uuid%

* name (string:50)
* description (string)
* category (string:20)

# IngredientsUsedInSteps

- step_id -> Steps.step_id
- ingredient_id -> Ingredients.ingredient_id

* amount (float)
* unit_id -> Units.unit_id

# Allergens

- allergen_id (int)

* name (string:50)
* description (string)

# Allergies

- ingredient_id -> Ingredients.ingredient_id
- allergen_id -> Allergens.allergen_id

# Substitutions

- ingredient_id -> Ingredients.ingredient_id // parent identifier e.g., linguini
- substitution_id -> Ingredients.ingredient_id // alternative options e.g., spaghetti

* description (string) // context on cooking deviations if using this sub

# Comments

- comment_id %long_uuid%

* recipe_id -> Recipes.recipe_id
* user_id -> Users.user_id
* created_on (datetime)
* body (string)
* last_edited (datetime)? // Nullable field to check if edit badges should display

# CommentLikes (CommentLike)

- comment_id -> Comments.comment_id // Removed redundant recipe_id lookup path
- user_id -> Users.user_id

# ShoppingListItems

- user_id -> Users.user_id
- ingredient_id -> Ingredients.ingredient_id // Tracks individual ingredients

* recipe_id -> Recipes.recipe_id? // Nullable shortcut path back to origin recipe (allows loose grocery items)
* amount (float)
* unit_id -> Units.unit_id
* is_checked (bool) // State flag to manage user interface strikethrough logic
