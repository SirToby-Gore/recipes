<?php

require_once __DIR__ . '/../init.php';

$conn->query('DELETE FROM `Ingredients` WHERE 1');
$conn->query('DELETE FROM `Allergies` WHERE 1');
$conn->query('DELETE FROM `Allergens` WHERE 1');

$ing_aubergine = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'aubergine', 'Fresh purple aubergine', 'vegetable');
$ing_aubergine->create();

$ing_bacon_rashers = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bacon rashers', 'Smoked pork bacon rashers', 'meat');
$ing_bacon_rashers->create();

$ing_bbq_sauce = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bbq sauce', 'Sweet and smoky barbecue sauce', 'sauce');
$ing_bbq_sauce->create();

$ing_beansprouts = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beansprouts', 'Crisp fresh beansprouts', 'vegetable');
$ing_beansprouts->create();

$ing_beef_stock = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beef stock', 'Rich liquid beef stock', 'pantry');
$ing_beef_stock->create();

$ing_black_olives = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black olives', 'Pitted black olives', 'pantry');
$ing_black_olives->create();

$ing_brandy = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brandy', 'Cooking brandy', 'alcohol');
$ing_brandy->create();

$ing_breadcrumbs = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'breadcrumbs', 'Dry fine breadcrumbs', 'pantry');
$ing_breadcrumbs->create();

$ing_brie = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brie', 'Creamy French Brie cheese', 'dairy');
$ing_brie->create();

$ing_burger_buns = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'burger buns', 'Soft sesame burger buns', 'bakery');
$ing_burger_buns->create();

$ing_butter = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'butter', 'Salted dairy butter', 'dairy');
$ing_butter->create();

$ing_cardamom_pods = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cardamom pods', 'Whole green cardamom pods', 'spices');
$ing_cardamom_pods->create();

$ing_carrot = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'carrot', 'Sweet orange carrots', 'vegetable');
$ing_carrot->create();

$ing_caster_sugar = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'caster sugar', 'Fine caster sugar', 'pantry');
$ing_caster_sugar->create();

$ing_cayenne_pepper = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cayenne pepper', 'Spicy ground cayenne pepper', 'spices');
$ing_cayenne_pepper->create();

$ing_celery = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'celery', 'Crisp celery stalks', 'vegetable');
$ing_celery->create();

$ing_cheddar_cheese = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cheddar cheese', 'Grated mature cheddar cheese', 'dairy');
$ing_cheddar_cheese->create();

$ing_chicken_breast = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken breast', 'Skinless chicken breasts', 'meat');
$ing_chicken_breast->create();

$ing_chicken_stock = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken stock', 'Savory chicken stock', 'pantry');
$ing_chicken_stock->create();

$ing_chicken_thighs = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken thighs', 'Boneless chicken thighs', 'meat');
$ing_chicken_thighs->create();

$ing_chilli_powder = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chilli powder', 'Ground red chilli powder', 'spices');
$ing_chilli_powder->create();

$ing_chips = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chips', 'Frozen potato chips', 'pantry');
$ing_chips->create();

$ing_chopped_tomatoes = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chopped tomatoes', 'Tinned chopped tomatoes', 'pantry');
$ing_chopped_tomatoes->create();

$ing_chorizo_sausage = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chorizo sausage', 'Spiced Spanish chorizo sausage', 'meat');
$ing_chorizo_sausage->create();

$ing_cider = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cider', 'Apple cooking cider', 'alcohol');
$ing_cider->create();

$ing_cooked_prawns = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cooked prawns', 'Peeled cooked prawns', 'seafood');
$ing_cooked_prawns->create();

$ing_courgette = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'courgette', 'Fresh green courgette', 'vegetable');
$ing_courgette->create();

$ing_cranberry_sauce = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cranberry sauce', 'Sweet cranberry sauce', 'sauce');
$ing_cranberry_sauce->create();

$ing_creme_fraiche = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'creme fraiche', 'Rich crème fraîche', 'dairy');
$ing_creme_fraiche->create();

$ing_cucumber = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cucumber', 'Crisp fresh cucumber', 'vegetable');
$ing_cucumber->create();

$ing_dark_chocolate = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dark chocolate', 'Rich dark chocolate', 'pantry');
$ing_dark_chocolate->create();

$ing_desert_apple = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'desert apple', 'Sweet dessert apples', 'fruit');
$ing_desert_apple->create();

$ing_diced_green_bell_pepper = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'diced green bell pepper', 'Diced green bell pepper', 'vegetable');
$ing_diced_green_bell_pepper->create();

$ing_dijon_mustard = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dijon mustard', 'Sharp Dijon mustard', 'sauce');
$ing_dijon_mustard->create();

$ing_double_cream = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'double cream', 'Rich double cream', 'dairy');
$ing_double_cream->create();

$ing_dried_oregano = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried oregano', 'Aromatic dried oregano', 'spices');
$ing_dried_oregano->create();

$ing_espresso = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'espresso', 'Strong brewed espresso coffee', 'pantry');
$ing_espresso->create();

$ing_fennel_seed = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fennel seed', 'Whole fennel seeds', 'spices');
$ing_fennel_seed->create();

$ing_finger_biscuits = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'finger biscuits', 'Sweet ladyfinger biscuits', 'bakery');
$ing_finger_biscuits->create();

$ing_floret_broccoli = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'floret broccoli', 'Fresh broccoli florets', 'vegetable');
$ing_floret_broccoli->create();

$ing_fresh_basil = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh basil', 'Fragrant fresh basil leaves', 'vegetable');
$ing_fresh_basil->create();

$ing_fresh_ginger = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh ginger', 'Fresh ginger root', 'vegetable');
$ing_fresh_ginger->create();

$ing_fresh_mint = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh mint', 'Cool fresh mint leaves', 'vegetable');
$ing_fresh_mint->create();

$ing_frozen_peas = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'frozen peas', 'Sweet frozen peas', 'vegetable');
$ing_frozen_peas->create();

$ing_garam_masala = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garam masala', 'Aromatic garam masala spice blend', 'spices');
$ing_garam_masala->create();

$ing_garlic_cloves = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garlic cloves', 'Fresh garlic cloves', 'vegetable');
$ing_garlic_cloves->create();

$ing_gnocchi = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gnocchi', 'Soft potato gnocchi', 'pantry');
$ing_gnocchi->create();

$ing_golden_syrup = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'golden syrup', 'Sweet golden syrup', 'pantry');
$ing_golden_syrup->create();

$ing_greek_yogurt = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'greek yogurt', 'Thick Greek yogurt', 'dairy');
$ing_greek_yogurt->create();

$ing_green_beans = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green beans', 'Fresh green beans', 'vegetable');
$ing_green_beans->create();

$ing_ground_black_pepper = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground black pepper', 'Ground black pepper', 'spices');
$ing_ground_black_pepper->create();

$ing_ground_cinnamon = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground cinnamon', 'Ground sweet cinnamon', 'spices');
$ing_ground_cinnamon->create();

$ing_ground_coriander = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground coriander', 'Ground coriander seeds', 'spices');
$ing_ground_coriander->create();

$ing_ground_cumin = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground cumin', 'Ground cumin seeds', 'spices');
$ing_ground_cumin->create();

$ing_ground_nutmeg = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground nutmeg', 'Ground aromatic nutmeg', 'spices');
$ing_ground_nutmeg->create();

$ing_gruyere_cheese = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gruyere cheese', 'Swiss Gruyère cheese', 'dairy');
$ing_gruyere_cheese->create();

$ing_iceberg_lettuce = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'iceberg lettuce', 'Crisp iceberg lettuce', 'vegetable');
$ing_iceberg_lettuce->create();

$ing_large_eggs = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'large eggs', 'Large free-range eggs', 'dairy');
$ing_large_eggs->create();

$ing_large_potatoes = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'large potatoes', 'Large baking potatoes', 'vegetable');
$ing_large_potatoes->create();

$ing_lasagne_sheets = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lasagne sheets', 'Dried lasagne sheets', 'pantry');
$ing_lasagne_sheets->create();

$ing_leeks = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'leeks', 'Fresh sliced leeks', 'vegetable');
$ing_leeks->create();

$ing_lemon_juice = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lemon juice', 'Freshly squeezed lemon juice', 'pantry');
$ing_lemon_juice->create();

$ing_mango_chutney = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mango chutney', 'Sweet mango chutney', 'sauce');
$ing_mango_chutney->create();

$ing_mascarpone = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mascarpone', 'Creamy Italian mascarpone', 'dairy');
$ing_mascarpone->create();

$ing_mayonaisse = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mayonaisse', 'Creamy mayonnaise', 'sauce');
$ing_mayonaisse->create();

$ing_mild_curry_powder = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mild curry powder', 'Mild curry powder blend', 'spices');
$ing_mild_curry_powder->create();

$ing_minced_beef = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'minced beef', 'Lean minced beef', 'meat');
$ing_minced_beef->create();

$ing_mozzarella_ball = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mozzarella ball', 'Fresh mozzarella cheese ball', 'dairy');
$ing_mozzarella_ball->create();

$ing_olive_oil = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'olive oil', 'Extra virgin olive oil', 'pantry');
$ing_olive_oil->create();

$ing_paella_rice = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'paella rice', 'Short-grain paella rice', 'pantry');
$ing_paella_rice->create();

$ing_parmesan_cheese = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'parmesan cheese', 'Grated Parmesan cheese', 'dairy');
$ing_parmesan_cheese->create();

$ing_penne = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'penne', 'Dried penne pasta', 'pantry');
$ing_penne->create();

$ing_pesto = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pesto', 'Green basil pesto', 'sauce');
$ing_pesto->create();

$ing_phyllo_pastry = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'phyllo pastry', 'Paper-thin phyllo pastry sheets', 'bakery');
$ing_phyllo_pastry->create();

$ing_pita_bread = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pita bread', 'Soft pita bread pockets', 'bakery');
$ing_pita_bread->create();

$ing_plain_flour = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'plain flour', 'All-purpose plain flour', 'pantry');
$ing_plain_flour->create();

$ing_pork_loin = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork loin', 'Tender pork loin medallions', 'meat');
$ing_pork_loin->create();

$ing_pork_mince = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork mince', 'Lean minced pork', 'meat');
$ing_pork_mince->create();

$ing_pork_sausages = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork sausages', 'Premium pork sausages', 'meat');
$ing_pork_sausages->create();

$ing_puff_pastry = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'puff pastry', 'Flaky puff pastry sheets', 'bakery');
$ing_puff_pastry->create();

$ing_raw_prawns = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'raw prawns', 'Fresh raw prawns', 'seafood');
$ing_raw_prawns->create();

$ing_red_bell_pepper = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red bell pepper', 'Sweet red bell pepper', 'vegetable');
$ing_red_bell_pepper->create();

$ing_red_kidney_beans = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red kidney beans', 'Tinned red kidney beans', 'pantry');
$ing_red_kidney_beans->create();

$ing_red_onion = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red onion', 'Mild red onion', 'vegetable');
$ing_red_onion->create();

$ing_red_wine = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red wine', 'Rich and sweeter than a white wine', 'drinks');
$ing_red_wine->create();

$ing_saffron = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'saffron', 'Precious saffron threads', 'spices');
$ing_saffron->create();

$ing_salmon_fillet = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'salmon fillet', 'Fresh salmon fillets', 'seafood');
$ing_salmon_fillet->create();

$ing_sea_salt = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sea salt', 'Fine sea salt', 'spices');
$ing_sea_salt->create();

$ing_smoked_paprika = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'smoked paprika', 'Smoky red paprika', 'spices');
$ing_smoked_paprika->create();

$ing_soy_sauce = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'soy sauce', 'Savory soy sauce', 'sauce');
$ing_soy_sauce->create();

$ing_spinach = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spinach', 'Fresh baby spinach leaves', 'vegetable');
$ing_spinach->create();

$ing_spring_onion = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spring onion', 'Fresh spring onions', 'vegetable');
$ing_spring_onion->create();

$ing_spring_roll_wrappers = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spring roll wrappers', 'Crispy spring roll wrappers', 'bakery');
$ing_spring_roll_wrappers->create();

$ing_stilton_cheese = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'stilton cheese', 'Punchy blue Stilton cheese', 'dairy');
$ing_stilton_cheese->create();

$ing_strong_bread_flour = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'strong bread flour', 'Strong white bread flour', 'pantry');
$ing_strong_bread_flour->create();

$ing_sunflower_oil = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sunflower oil', 'Pure sunflower oil', 'pantry');
$ing_sunflower_oil->create();

$ing_tinned_peaches = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tinned peaches', 'Sweet tinned peach slices', 'fruit');
$ing_tinned_peaches->create();

$ing_tomato = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato', 'Ripe red tomatoes', 'vegetable');
$ing_tomato->create();

$ing_tomato_passata = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato passata', 'Smooth tomato passata', 'sauce');
$ing_tomato_passata->create();

$ing_tomato_puree = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato puree', 'Rich concentrated tomato puree', 'sauce');
$ing_tomato_puree->create();

$ing_tuna_steak = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tuna steak', 'Fresh tuna steaks', 'seafood');
$ing_tuna_steak->create();

$ing_turkey_breast = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turkey breast', 'Tender turkey breast fillets', 'meat');
$ing_turkey_breast->create();

$ing_turmeric = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turmeric', 'Ground yellow turmeric powder', 'spices');
$ing_turmeric->create();

$ing_vegetable_oil = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable oil', 'All-purpose vegetable oil', 'pantry');
$ing_vegetable_oil->create();

$ing_vegetable_stock = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable stock', 'Liquid vegetable stock', 'pantry');
$ing_vegetable_stock->create();

$ing_white_bread = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white bread', 'Sliced white bread', 'bakery');
$ing_white_bread->create();

$ing_white_fish_fillet = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white fish fillet', 'Fresh white fish fillets', 'seafood');
$ing_white_fish_fillet->create();

$ing_white_onion = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white onion', 'Mild white onion', 'vegetable');
$ing_white_onion->create();

$ing_whole_lemon = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole lemon', 'Fresh whole lemon', 'fruit');
$ing_whole_lemon->create();

$ing_whole_milk = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole milk', 'Whole dairy milk', 'dairy');
$ing_whole_milk->create();

$ing_yeast = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'yeast', 'Active dried yeast', 'pantry');
$ing_yeast->create();



$i = 1;

$alg_celery = new Allergen($i++, 'celery', 'Celery');
$alg_celery->create();

$alg_cereals_gluten = new Allergen($i++, 'cereals gluten', 'Cereals containing gluten');
$alg_cereals_gluten->create();

$alg_crustaceans = new Allergen($i++, 'crustaceans', 'Crustaceans');
$alg_crustaceans->create();

$alg_eggs = new Allergen($i++, 'eggs', 'Eggs');
$alg_eggs->create();

$alg_fish = new Allergen($i++, 'fish', 'Fish');
$alg_fish->create();

$alg_lupin = new Allergen($i++, 'lupin', 'Lupin');
$alg_lupin->create();

$alg_milk = new Allergen($i++, 'milk', 'Milk');
$alg_milk->create();

$alg_molluscs = new Allergen($i++, 'molluscs', 'Molluscs');
$alg_molluscs->create();

$alg_mustard = new Allergen($i++, 'mustard', 'Mustard');
$alg_mustard->create();

$alg_nuts = new Allergen($i++, 'nuts', 'Nuts');
$alg_nuts->create();

$alg_peanuts = new Allergen($i++, 'peanuts', 'Peanuts');
$alg_peanuts->create();

$alg_sesame = new Allergen($i++, 'sesame', 'Sesame seeds');
$alg_sesame->create();

$alg_soya = new Allergen($i++, 'soya', 'Soya');
$alg_soya->create();

$alg_sulphites = new Allergen($i++, 'sulphites', 'Sulphur dioxide/sulphites');
$alg_sulphites->create();



(new Allergy($ing_breadcrumbs->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_brie->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_burger_buns->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_butter->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_celery->ingredient_id, $alg_celery->allergen_id))->create();

(new Allergy($ing_cheddar_cheese->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_chicken_stock->ingredient_id, $alg_celery->allergen_id))->create();

(new Allergy($ing_cooked_prawns->ingredient_id, $alg_crustaceans->allergen_id))->create();

(new Allergy($ing_creme_fraiche->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_dark_chocolate->ingredient_id, $alg_milk->allergen_id))->create();
(new Allergy($ing_dark_chocolate->ingredient_id, $alg_soya->allergen_id))->create();

(new Allergy($ing_dijon_mustard->ingredient_id, $alg_mustard->allergen_id))->create();

(new Allergy($ing_double_cream->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_finger_biscuits->ingredient_id, $alg_cereals_gluten->allergen_id))->create();
(new Allergy($ing_finger_biscuits->ingredient_id, $alg_eggs->allergen_id))->create();

(new Allergy($ing_gnocchi->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_greek_yogurt->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_gruyere_cheese->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_large_eggs->ingredient_id, $alg_eggs->allergen_id))->create();

(new Allergy($ing_lasagne_sheets->ingredient_id, $alg_cereals_gluten->allergen_id))->create();
(new Allergy($ing_lasagne_sheets->ingredient_id, $alg_eggs->allergen_id))->create();

(new Allergy($ing_mascarpone->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_mayonaisse->ingredient_id, $alg_eggs->allergen_id))->create();
(new Allergy($ing_mayonaisse->ingredient_id, $alg_mustard->allergen_id))->create();

(new Allergy($ing_mozzarella_ball->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_parmesan_cheese->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_penne->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_pesto->ingredient_id, $alg_milk->allergen_id))->create();
(new Allergy($ing_pesto->ingredient_id, $alg_nuts->allergen_id))->create();

(new Allergy($ing_phyllo_pastry->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_pita_bread->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_plain_flour->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_pork_sausages->ingredient_id, $alg_cereals_gluten->allergen_id))->create();
(new Allergy($ing_pork_sausages->ingredient_id, $alg_sulphites->allergen_id))->create();

(new Allergy($ing_puff_pastry->ingredient_id, $alg_cereals_gluten->allergen_id))->create();
(new Allergy($ing_puff_pastry->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_raw_prawns->ingredient_id, $alg_crustaceans->allergen_id))->create();

(new Allergy($ing_salmon_fillet->ingredient_id, $alg_fish->allergen_id))->create();

(new Allergy($ing_soy_sauce->ingredient_id, $alg_soya->allergen_id))->create();
(new Allergy($ing_soy_sauce->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_spring_roll_wrappers->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_stilton_cheese->ingredient_id, $alg_milk->allergen_id))->create();

(new Allergy($ing_strong_bread_flour->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_tuna_steak->ingredient_id, $alg_fish->allergen_id))->create();

(new Allergy($ing_white_bread->ingredient_id, $alg_cereals_gluten->allergen_id))->create();

(new Allergy($ing_white_fish_fillet->ingredient_id, $alg_fish->allergen_id))->create();

(new Allergy($ing_whole_milk->ingredient_id, $alg_milk->allergen_id))->create();

