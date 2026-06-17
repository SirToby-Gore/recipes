import sys
import re


def main():
    if len(sys.argv) < 2:
        sys.exit(1)

    file_path = sys.argv[1]

    category_map = {
        'aubergine': ('vegetable', 'Fresh purple aubergine'),
        'bacon_rashers': ('meat', 'Smoked pork bacon rashers'),
        'bbq_sauce': ('sauce', 'Sweet and smoky barbecue sauce'),
        'beansprouts': ('vegetable', 'Crisp fresh beansprouts'),
        'beef_stock': ('pantry', 'Rich liquid beef stock'),
        'black_olives': ('pantry', 'Pitted black olives'),
        'brandy': ('alcohol', 'Cooking brandy'),
        'breadcrumbs': ('pantry', 'Dry fine breadcrumbs'),
        'brie': ('dairy', 'Creamy French Brie cheese'),
        'burger_buns': ('bakery', 'Soft sesame burger buns'),
        'butter': ('dairy', 'Salted dairy butter'),
        'cardamom_pods': ('spices', 'Whole green cardamom pods'),
        'carrot': ('vegetable', 'Sweet orange carrots'),
        'caster_sugar': ('pantry', 'Fine caster sugar'),
        'cayenne_pepper': ('spices', 'Spicy ground cayenne pepper'),
        'celery': ('vegetable', 'Crisp celery stalks'),
        'cheddar_cheese': ('dairy', 'Grated mature cheddar cheese'),
        'chicken_breast': ('meat', 'Skinless chicken breasts'),
        'chicken_stock': ('pantry', 'Savory chicken stock'),
        'chicken_thighs': ('meat', 'Boneless chicken thighs'),
        'chilli_powder': ('spices', 'Ground red chilli powder'),
        'chips': ('pantry', 'Frozen potato chips'),
        'chopped_tomatoes': ('pantry', 'Tinned chopped tomatoes'),
        'chorizo_sausage': ('meat', 'Spiced Spanish chorizo sausage'),
        'cider': ('alcohol', 'Apple cooking cider'),
        'cooked_prawns': ('seafood', 'Peeled cooked prawns'),
        'courgette': ('vegetable', 'Fresh green courgette'),
        'cranberry_sauce': ('sauce', 'Sweet cranberry sauce'),
        'creme_fraiche': ('dairy', 'Rich crème fraîche'),
        'cucumber': ('vegetable', 'Crisp fresh cucumber'),
        'dark_chocolate': ('pantry', 'Rich dark chocolate'),
        'desert_apple': ('fruit', 'Sweet dessert apples'),
        'diced_green_bell_pepper': ('vegetable', 'Diced green bell pepper'),
        'dijon_mustard': ('sauce', 'Sharp Dijon mustard'),
        'double_cream': ('dairy', 'Rich double cream'),
        'dried_oregano': ('spices', 'Aromatic dried oregano'),
        'espresso': ('pantry', 'Strong brewed espresso coffee'),
        'fennel_seed': ('spices', 'Whole fennel seeds'),
        'finger_biscuits': ('bakery', 'Sweet ladyfinger biscuits'),
        'floret_broccoli': ('vegetable', 'Fresh broccoli florets'),
        'fresh_basil': ('vegetable', 'Fragrant fresh basil leaves'),
        'fresh_ginger': ('vegetable', 'Fresh ginger root'),
        'fresh_mint': ('vegetable', 'Cool fresh mint leaves'),
        'frozen_peas': ('vegetable', 'Sweet frozen peas'),
        'garam_masala': ('spices', 'Aromatic garam masala spice blend'),
        'garlic_cloves': ('vegetable', 'Fresh garlic cloves'),
        'gnocchi': ('pantry', 'Soft potato gnocchi'),
        'golden_syrup': ('pantry', 'Sweet golden syrup'),
        'greek_yogurt': ('dairy', 'Thick Greek yogurt'),
        'green_beans': ('vegetable', 'Fresh green beans'),
        'ground_black_pepper': ('spices', 'Ground black pepper'),
        'ground_cinnamon': ('spices', 'Ground sweet cinnamon'),
        'ground_coriander': ('spices', 'Ground coriander seeds'),
        'ground_cumin': ('spices', 'Ground cumin seeds'),
        'ground_nutmeg': ('spices', 'Ground aromatic nutmeg'),
        'gruyere_cheese': ('dairy', 'Swiss Gruyère cheese'),
        'iceberg_lettuce': ('vegetable', 'Crisp iceberg lettuce'),
        'large_eggs': ('dairy', 'Large free-range eggs'),
        'large_potatoes': ('vegetable', 'Large baking potatoes'),
        'lasagne_sheets': ('pantry', 'Dried lasagne sheets'),
        'leeks': ('vegetable', 'Fresh sliced leeks'),
        'lemon_juice': ('pantry', 'Freshly squeezed lemon juice'),
        'mango_chutney': ('sauce', 'Sweet mango chutney'),
        'mascarpone': ('dairy', 'Creamy Italian mascarpone'),
        'mayonaisse': ('sauce', 'Creamy mayonnaise'),
        'mild_curry_powder': ('spices', 'Mild curry powder blend'),
        'minced_beef': ('meat', 'Lean minced beef'),
        'mozzarella_ball': ('dairy', 'Fresh mozzarella cheese ball'),
        'olive_oil': ('pantry', 'Extra virgin olive oil'),
        'paella_rice': ('pantry', 'Short-grain paella rice'),
        'parmesan_cheese': ('dairy', 'Grated Parmesan cheese'),
        'penne': ('pantry', 'Dried penne pasta'),
        'pesto': ('sauce', 'Green basil pesto'),
        'phyllo_pastry': ('bakery', 'Paper-thin phyllo pastry sheets'),
        'pita_bread': ('bakery', 'Soft pita bread pockets'),
        'plain_flour': ('pantry', 'All-purpose plain flour'),
        'pork_loin': ('meat', 'Tender pork loin medallions'),
        'pork_mince': ('meat', 'Lean minced pork'),
        'pork_sausages': ('meat', 'Premium pork sausages'),
        'puff_pastry': ('bakery', 'Flaky puff pastry sheets'),
        'raw_prawns': ('seafood', 'Fresh raw prawns'),
        'red_bell_pepper': ('vegetable', 'Sweet red bell pepper'),
        'red_kidney_beans': ('pantry', 'Tinned red kidney beans'),
        'red_onion': ('vegetable', 'Mild red onion'),
        'saffron': ('spices', 'Precious saffron threads'),
        'salmon_fillet': ('seafood', 'Fresh salmon fillets'),
        'sea_salt': ('spices', 'Fine sea salt'),
        'smoked_paprika': ('spices', 'Smoky red paprika'),
        'soy_sauce': ('sauce', 'Savory soy sauce'),
        'spinach': ('vegetable', 'Fresh baby spinach leaves'),
        'spring_onion': ('vegetable', 'Fresh spring onions'),
        'spring_roll_wrappers': ('bakery', 'Crispy spring roll wrappers'),
        'stilton_cheese': ('dairy', 'Punchy blue Stilton cheese'),
        'strong_bread_flour': ('pantry', 'Strong white bread flour'),
        'sunflower_oil': ('pantry', 'Pure sunflower oil'),
        'tinned_peaches': ('fruit', 'Sweet tinned peach slices'),
        'tomato': ('vegetable', 'Ripe red tomatoes'),
        'tomato_passata': ('sauce', 'Smooth tomato passata'),
        'tomato_puree': ('sauce', 'Rich concentrated tomato puree'),
        'tuna_steak': ('seafood', 'Fresh tuna steaks'),
        'turkey_breast': ('meat', 'Tender turkey breast fillets'),
        'turmeric': ('spices', 'Ground yellow turmeric powder'),
        'vegetable_oil': ('pantry', 'All-purpose vegetable oil'),
        'vegetable_stock': ('pantry', 'Liquid vegetable stock'),
        'white_bread': ('bakery', 'Sliced white bread'),
        'white_fish_fillet': ('seafood', 'Fresh white fish fillets'),
        'white_onion': ('vegetable', 'Mild white onion'),
        'whole_lemon': ('fruit', 'Fresh whole lemon'),
        'whole_milk': ('dairy', 'Whole dairy milk'),
        'yeast': ('pantry', 'Active dried yeast')
    }

    try:
        with open(file_path, 'r', encoding='utf-8') as file:
            php_content = file.read()
    except IOError:
        sys.exit(1)

    pattern = r"\$ing_([a-zA-Z0-9_]+)\s*=\s*new\s+Ingredient\(\s*new_uuid\(\s*'ingredient_id'\s*,\s*'Ingredients'\s*\)\s*,\s*'([^']*)'\s*,\s*''\s*\);"

    def replace_match(match):
        variable_name = match.group(1)
        ingredient_name = match.group(2)

        category, description = category_map.get(
            ingredient_name, ('pantry', 'Fresh ingredient'))

        return f"$ing_{variable_name} = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), '{ingredient_name}', '{description}', '{category}');"

    updated_content = re.sub(pattern, replace_match, php_content)

    try:
        with open(file_path, 'w', encoding='utf-8') as file:
            file.write(updated_content)
    except IOError:
        sys.exit(1)


if __name__ == '__main__':
    main()
