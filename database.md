# Users
* id (100 char)
* name (100 char)
* email (150 char)
* password hash (255 char): uses sha 255
* salt (10 char)
* created on (datetime)


# Tokens
* token (200 char)
* user id (ref -> users.id)
* created on (date): delete after 24hr


# Recipes
* id (100 chars)
* title (100 chars)
* description (text)
* number of steps (int)
* total time (int)
* portions (int)
* parent (ref -> recipes.id)?: used for when recipes have variants
* user id (ref -> users.id)


# Steps
* step number (int): the step e.g. 1
* recipe id (ref -> recipes.id)
* step (text)


# Tags
* recipe id (ref -> recipes.id)
* tag name (100 char)


# Ingredients
* id (100 char)
* name (50 char)
* description (text)


# Ingredients list
* recipe id (ref -> recipes.id)
* ingredient id (ref -> ingredients.id)
* amount (double)
* unit id (ref -> units.id)


# Units
* id (int)
* short hand (char 10)


# Allergy
* ingredient id (ref -> ingredients.id)
* allergen id (ref -> allergens.id)


# Allergens
* id (int)
* name (text)
* description (text)


# Substitutions
* ingredient id (ref -> ingredients.id): the parent id e.g. linguini
* substitution id (ref -> ingredients.id): the substitution e.g. spaghetti
* description (text): on how it can be used a sub


# Comment
* recipe id (ref -> recipes.id)
* body (text)
* user id (ref -> users.id)
* likes (int)
* created on (datetime)
* last edited (datetime)?

