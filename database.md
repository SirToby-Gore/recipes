```uuid
 (string:128)
```

```uuid
 (string:64)
```

# Users

- user_id %uuid%

* name (string:100)
* email (string:150)
* password_hash (string:255) // uses sha 255
* salt (string:32)
* created_on (string)

# Tokens

- token (string:200)

* user_id -> Users.user_id
* created_on (string) // delete after 24hr

# Recipes

- recipe_id %uuid%

* title (string:100)
* description (string)
* number_of_steps (int)
* total_time (int)
* portions (int)
* parent -> Recipes.recipe_id? // used for when recipes have variants
* user_id -> Users.user_id

# Steps

- step_id $long_uuid%

* step_number (int) // the step e.g. 1
* recipe_id -> Recipes.recipe_id
* step (string)

# IngredientsUsedInSteps

- step_id -> Steps.step_id

* ingredient_id -> Ingredients.ingredient_id
* amount (float)
* unit -> Units.unit_id

# Tags

- recipe_id -> Recipes.recipe_id
- tag_name (string:20)

# Ingredients

- ingredient_id %uuid%

* name (string:50)
* description (string)

# IngredientsLists

- recipe_id -> Recipes.recipe_id
- ingredient_id -> Ingredients.ingredient_id

* amount (float)
* unit_id -> Units.unit_id

# Units

- unit_id (int)

* short_hand (string:10)

# CompatibleUnits

- base_unit -> Units.unit_id
- new_unit -> Units.unit_id

# Allergens

- allergen_id (int)

* name (string)
* description (string)

# Allergies

- ingredient_id -> Ingredients.ingredient_id
- allergen_id -> Allergens.allergen_id

# Substitutions

- ingredient_id -> Ingredients.ingredient_id // the parent id e.g. linguini
- substitution_id -> Ingredients.ingredient_id // the substitution e.g. spaghetti

* description (string) // on how it can be used a sub

# Comments

- comment_id (string:100)
- recipe_id -> Recipes.recipe_id
- user_id -> Users.user_id
- created_on (string)

* body (string)
* last_edited (string)?

# Likes (Like)

- recipe_id -> Recipes.recipe_id
- comment_id -> Comments.comment_id
- user_id -> Users.user_id

# ShoppingListItem

- user_id -> Users.user_id
- recipe_id -> Recipes.recipe_id

* amount (int)
