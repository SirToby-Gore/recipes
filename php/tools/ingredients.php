<?php

require_once __DIR__ . '/../init.php';

$ing_db = [];
$file_path_json = __DIR__ . '/_ingredients.json';

if (!file_exists($file_path_json)) {
    echo "Creating Ingredients from scratch";

    $conn->query('DELETE FROM `Ingredients` WHERE 1');
    $conn->query('DELETE FROM `Allergies` WHERE 1');
    $conn->query('DELETE FROM `Allergens` WHERE 1');


    #region ingredients

    $ing_db['active_dry_yeast'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'active dry yeast', 'Dried granules of yeast used for bread making', 'baking');
    $ing_db['allspice_ground'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground allspice', 'Pimento berry powder with a warm multi-spice flavor profiles', 'spices');
    $ing_db['almond_extract'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'almond extract', 'Intense almond flavouring liquid', 'baking');
    $ing_db['almond_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'almond flour', 'Finely milled blanched almonds used as a grain-free flour substitute', 'baking');
    $ing_db['almond_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'almond milk', 'Plant-based nut milk alternative', 'dairy-free');
    $ing_db['anchovy_fillets'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'anchovy fillets', 'Small, salt-cured fish packed in olive oil', 'seafood');
    $ing_db['anise_star'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'star anise', 'Star-shaped aromatic pod imparting a strong liquorice flavor', 'spices');
    $ing_db['apple_cider_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'apple cider vinegar', 'Fermented apple juice vinegar', 'condiments');
    $ing_db['apple_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'apple juice', 'Sweet, clear juice pressed from apples', 'beverages');
    $ing_db['apricot_jam'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'apricot jam', 'Sweet preserve frequently used for glazing pastries and meats', 'condiments');
    $ing_db['arborio_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'arborio_rice', 'Italian short-grain rice ideal for risotto', 'grains');
    $ing_db['arrowroot_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'arrowroot powder', 'Starch thickener that remains completely clear when cooked', 'baking');
    $ing_db['artichoke_hearts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'artichoke hearts', 'Canned or brined tender inner leaves of globe artichokes', 'vegetables');
    $ing_db['asparagus_spears'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'asparagus spears', 'Tender green perennial spring vegetable stalks', 'produce');
    $ing_db['aubergine'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'aubergine', 'Fresh purple aubergine', 'vegetable');
    $ing_db['avocado'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'avocado', 'Rich, creamy green fruit', 'produce');
    $ing_db['baby_corn'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'baby corn', 'Miniature immature ears of sweetcorn eaten whole', 'produce');
    $ing_db['baby_spinach'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'baby spinach', 'Tender young leaves of raw culinary spinach', 'produce');
    $ing_db['bacon_rashers'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bacon rashers', 'Smoked pork bacon rashers', 'meat');
    $ing_db['baker_yeast_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh yeast', 'Cake or compressed live yeast preferred for traditional baking', 'baking');
    $ing_db['baking_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'baking powder', 'Leavening agent containing carbonate and acid', 'baking');
    $ing_db['balsamic_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'balsamic vinegar', 'Dark, concentrated, intensely flavoured vinegar', 'condiments');
    $ing_db['bamboo_shoots'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bamboo shoots', 'Crisp, sliced edible sprouts of bamboo varieties', 'canned');
    $ing_db['barbecue_rub'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bbq spice rub', 'Smoky, sweet dry seasoning mixture for meats', 'spices');
    $ing_db['barley_pearl'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pearl barley', 'Whole barley grains processed to remove the fibrous outer hull', 'grains');
    $ing_db['basmati_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'basmati rice', 'Long, slender-grained aromatic rice', 'grains');
    $ing_db['bay_leaves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bay leaves', 'Aromatic dried or fresh leaves used for simmering', 'herbs');
    $ing_db['bbq_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bbq sauce', 'Sweet and smoky barbecue sauce', 'sauce');
    $ing_db['beansprouts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beansprouts', 'Crisp fresh beansprouts', 'vegetable');
    $ing_db['beef_brisket'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beef brisket', 'Tough, flavorful cut from the breast section ideal for slow cooking', 'meat');
    $ing_db['beef_gelatine'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gelatine powder', 'Unflavored gelling agent extracted from animal collagen', 'baking');
    $ing_db['beef_mince'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beef mince', 'Ground lean or standard beef', 'meat');
    $ing_db['beef_rump_steak'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rump steak', 'Lean, highly flavorful cut of prime roasting beef', 'meat');
    $ing_db['beef_sirloin'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sirloin steak', 'Tender, juicy subprimal beef loin steak cut', 'meat');
    $ing_db['beef_stock'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beef stock', 'Rich liquid beef stock', 'pantry');
    $ing_db['beetroot_cooked'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cooked beetroot', 'Boiled or vacuum-packed sweet purple root vegetable', 'produce');
    $ing_db['bicarbonate_of_soda'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bicarbonate of soda', 'Pure sodium bicarbonate leavening agent', 'baking');
    $ing_db['black_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black beans', 'Canned or dried black turtle beans', 'pulses');
    $ing_db['black_olives'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black olives', 'Pitted black olives', 'pantry');
    $ing_db['black_peppercorns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole black peppercorns', 'Dried unripened fruit fruit segments for table grinders', 'spices');
    $ing_db['black_pudding'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black pudding', 'Traditional British blood sausage seasoned with oatmeal and spices', 'meat');
    $ing_db['black_treacle'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black treacle', 'Thick, dark, bitter-sweet syrup similar to molasses', 'sweeteners');
    $ing_db['blackcurrant_cordial'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'blackcurrant cordial', 'Concentrated fruit squash syrup', 'beverages');
    $ing_db['blueberries'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'blueberries', 'Small indigo-colored sweet berries', 'produce');
    $ing_db['bok_choy'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bok choy', 'Chinese white cabbage variety with crisp green leaves', 'produce');
    $ing_db['bouillon_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bouillon powder', 'Dehydrated concentrated vegetable or meat broth powder', 'pantry');
    $ing_db['brandy'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brandy', 'Cooking brandy', 'alcohol');
    $ing_db['brazil_nuts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brazil nuts', 'Large, rich, edible tropical seeds native to South America', 'nuts');
    $ing_db['bread_crumbs_panko'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'panko breadcrumbs', 'Flaky, Japanese-style light and crispy breadcrumbs', 'pantry');
    $ing_db['breadcrumbs'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'breadcrumbs', 'Dry fine breadcrumbs', 'pantry');
    $ing_db['brie'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brie', 'Creamy French Brie cheese', 'dairy');
    $ing_db['brown_onion'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brown onion', 'Standard versatile cooking onion', 'produce');
    $ing_db['brown_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brown rice', 'Whole-grain unpolished rice options retaining the outer bran layer', 'grains');
    $ing_db['brown_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brown sauce', 'Traditional tangy UK condiment featuring fruit bases and vinegar', 'condiments');
    $ing_db['brown_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brown sugar', 'Soft sugar containing residual molasses', 'baking');
    $ing_db['brussels_sprouts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brussels sprouts', 'Small leafy green cabbage-like buds harvested in winter', 'produce');
    $ing_db['buckwheat_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'buckwheat flour', 'Gluten-free flour with an earthy, nutty undertone', 'baking');
    $ing_db['bulgur_wheat'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'bulgur wheat', 'Parboiled, cracked wheat kernels central to Middle Eastern salads', 'grains');
    $ing_db['burger_buns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'burger buns', 'Soft sesame burger buns', 'bakery');
    $ing_db['butter_unsalted'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'unsalted butter', 'Salted dairy butter', 'dairy');
    $ing_db['butter_salted'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'salted butter', 'Churned dairy cream blended with structural table salt', 'dairy');
    $ing_db['buttermilk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'buttermilk', 'Fermented dairy liquid yielding a tangy flavor to baked goods', 'dairy');
    $ing_db['butternut_squash'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'butternut squash', 'Sweet, golden-fleshed winter squash variety', 'produce');
    $ing_db['cabbage_savoy'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'savoy cabbage', 'Crinkled, dark-green layered leafy cabbage head', 'produce');
    $ing_db['cacao_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cacao powder', 'Raw, cold-pressed unsweetened cacao beans', 'baking');
    $ing_db['camembert'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'camembert cheese', 'Moist, soft-ripened French cow milk cheese', 'dairy');
    $ing_db['candied_peel'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'candied peel', 'Sugar-preserved citrus fruit skins used in Christmas baking', 'baking');
    $ing_db['cannellini_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cannellini beans', 'White kidney beans popular in Mediterranean soups', 'pulses');
    $ing_db['canola_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rapeseed oil', 'Neutral vegetable cooking oil with a high smoke point', 'oils');
    $ing_db['capers'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'capers', 'Pickled flower buds of the caper bush', 'condiments');
    $ing_db['caraway_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'caraway seeds', 'Anise-scented seeds foundational to rye breads', 'spices');
    $ing_db['cardamom_pods'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cardamom pods', 'Whole green cardamom pods', 'spices');
    $ing_db['carrot'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'carrot', 'Sweet orange carrots', 'vegetable');
    $ing_db['cashew_nuts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cashew nuts', 'Creamy, kidney-shaped tree nuts', 'nuts');
    $ing_db['caster_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'caster sugar', 'Finely ground granulated white sugar', 'baking');
    $ing_db['cauliflower'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cauliflower', 'White cruciferous head vegetable', 'produce');
    $ing_db['cayenne_pepper'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cayenne pepper', 'Spicy ground cayenne pepper', 'spices');
    $ing_db['celery'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'celery', 'Crisp celery stalks', 'vegetable');
    $ing_db['celery_salt'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'celery salt', 'Seasoned salt blend incorporating crushed celery seeds', 'spices');
    $ing_db['celery_seed'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'celery seeds', 'Pungent whole seeds providing concentrated celery aroma', 'spices');
    $ing_db['chanterelles'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chanterelle mushrooms', 'Wild, golden funnel-shaped edible forest fungi', 'produce');
    $ing_db['chardo_swiss'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'swiss chard', 'Leafy green vegetable featuring prominent colored stalks', 'produce');
    $ing_db['cheddar_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cheddar cheese', 'Grated mature cheddar cheese', 'dairy');
    $ing_db['cherries_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh cherries', 'Sweet, dark red summer stone fruits', 'produce');
    $ing_db['cherries_glace'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'glace cherries', 'Sugar-saturated preserved cherries for fruitcakes', 'baking');
    $ing_db['chestnuts_vacuum'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'peeled chestnuts', 'Roasted, vacuum-packed sweet chestnuts ready for stuffing', 'pantry');
    $ing_db['chia_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chia seeds', 'Gel-forming hydrophilic edible seeds from Mexico', 'seeds');
    $ing_db['chicken_breast'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken breast', 'Skinless chicken breasts', 'meat');
    $ing_db['chicken_stock'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken stock', 'Savory chicken stock', 'pantry');
    $ing_db['chicken_thighs'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken thighs', 'Boneless chicken thighs', 'meat');
    $ing_db['chicken_wings'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chicken wings', 'Bone-in cuts of poultry wing sections', 'meat');
    $ing_db['chickpeas'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chickpeas', 'Garbanzo beans, cooked or canned', 'pulses');
    $ing_db['chilli_flakes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chilli flakes', 'Dried, crushed red hot peppers', 'spices');
    $ing_db['chilli_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chilli paste', 'Concentrated purée of hot peppers and oils', 'condiments');
    $ing_db['chilli_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chilli powder', 'Ground red chilli powder', 'spices');
    $ing_db['chinese_five_spice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'five-spice powder', 'Blend of star anise, cloves, cinnamon, pepper, and fennel', 'spices');
    $ing_db['chipotle_in_adobo'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chipotle in adobo', 'Smoked jalapeño peppers preserved in a tangy tomato marinade', 'pantry');
    $ing_db['chips'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chips', 'Frozen potato chips', 'pantry');
    $ing_db['chive_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried chives', 'Freeze-dried green chive rings', 'herbs');
    $ing_db['chives'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chives', 'Mild, onion-flavoured green herb strands', 'herbs');
    $ing_db['chopped_tomatoes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chopped tomatoes', 'Tinned chopped tomatoes', 'pantry');
    $ing_db['chorizo_sausage'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chorizo sausage', 'Spiced Spanish chorizo sausage', 'meat');
    $ing_db['cider'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cider', 'Apple cooking cider', 'alcohol');
    $ing_db['clams_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh clams', 'Live, shell-on saltwater bivalve molluscs', 'seafood');
    $ing_db['clove_ground'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground cloves', 'Intensely pungent flower bud powder', 'spices');
    $ing_db['cocoa_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cocoa powder', 'Standard Dutch-processed unsweetened baking cocoa', 'baking');
    $ing_db['coconut_cream'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coconut cream', 'Thick, low-moisture paste layer extracted from coconut pulp', 'canned');
    $ing_db['coconut_desiccated'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'desiccated coconut', 'Dried, shredded unsweetened white coconut flesh', 'baking');
    $ing_db['coconut_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coconut milk', 'Rich liquid extracted from grated coconut meat', 'canned');
    $ing_db['coconut_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coconut oil', 'Edible plant oil extracted from the kernel of mature coconuts', 'oils');
    $ing_db['coconut_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coconut sugar', 'Palm sugar produced from the sap of coco flower buds', 'sweeteners');
    $ing_db['cod_fillet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cod fillet', 'Flaky white saltwater fish central to fish and chips', 'seafood');
    $ing_db['condensed_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'condensed milk', 'Sweetened, highly concentrated evaporated cow milk', 'baking');
    $ing_db['cooked_prawns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cooked prawns', 'Peeled cooked prawns', 'seafood');
    $ing_db['coriander_leaves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coriander leaves', 'Fresh cilantro or coriander herb', 'herbs');
    $ing_db['coriander_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coriander seeds', 'Whole citrusy dried seeds of the coriander plant', 'spices');
    $ing_db['corn_kernels_canned'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'canned sweetcorn', 'Preserved sweet maize kernels packed in water', 'canned');
    $ing_db['corn_syrup_light'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'corn syrup', 'Liquid glucose sweetener that prevents sugar crystallization', 'baking');
    $ing_db['cornflour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cornflour', 'Fine white starch powder derived from maize', 'baking');
    $ing_db['cottage_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cottage cheese', 'Mild, unripened loose dairy curd cheese cheese', 'dairy');
    $ing_db['courgette'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'courgette', 'Fresh green courgette', 'vegetable');
    $ing_db['couscous'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'couscous', 'Small steamed granules of rolled semolina', 'grains');
    $ing_db['crab_meat_canned'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'crab meat', 'White and brown cooked crab meat packed in brine', 'seafood');
    $ing_db['cranberries_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried cranberries', 'Sweetened, dehydrated red cranberries', 'baking');
    $ing_db['cranberries_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh cranberries', 'Tart, acidic whole red autumn berries', 'produce');
    $ing_db['cranberry_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cranberry sauce', 'Sweet cranberry sauce', 'sauce');
    $ing_db['cream_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cream cheese', 'Soft, rich spreadable white dairy cheese', 'dairy');
    $ing_db['cream_of_tartar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cream of tartar', 'Acidic potassium bitartrate powder used for stabilizing egg whites', 'baking');
    $ing_db['creme_fraiche'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'creme fraiche', 'Rich crème fraîche', 'dairy');
    $ing_db['crisco_shortening'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable shortening', 'Solid hydrogenated vegetable fat used for pastry crusts', 'baking');
    $ing_db['cucumber'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cucumber', 'Crisp fresh cucumber', 'vegetable');
    $ing_db['cumin_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cumin seeds', 'Whole aromatic, earthy dried cumin seeds', 'spices');
    $ing_db['currants_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried currants', 'Small, intensely sweet dried Zante grape varieties', 'baking');
    $ing_db['curry_leaves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'curry leaves', 'Fresh, aromatic glossy leaves from the curry tree', 'herbs');
    $ing_db['dark_brown_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dark brown soft sugar', 'Moist sugar containing dense cane molasses components', 'baking');
    $ing_db['dark_chocolate'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dark chocolate', 'Rich dark chocolate', 'pantry');
    $ing_db['dates_medjool'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'medjool dates', 'Large, sweet, rich fleshy dried stone fruit fruits', 'pantry');
    $ing_db['demerara_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'demerara sugar', 'Light brown cane sugar with large, crunchy structural crystals', 'baking');
    $ing_db['desert_apple'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'desert apple', 'Sweet dessert apples', 'fruit');
    $ing_db['diced_green_bell_pepper'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'diced green bell pepper', 'Diced green bell pepper', 'vegetable');
    $ing_db['dijon_mustard'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dijon mustard', 'Sharp Dijon mustard', 'sauce');
    $ing_db['dill_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh dill', 'Feathery green herb with an aromatic anise profile', 'herbs');
    $ing_db['double_cream'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'double cream', 'Thick dairy cream with high fat content', 'dairy');
    $ing_db['dried_apricots'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried apricots', 'Dehydrated pitted apricot halves', 'baking');
    $ing_db['dried_oregano'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried oregano', 'Aromatic dried oregano', 'spices');
    $ing_db['dried_thyme'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried thyme', 'Pungent, earthy dried Mediterranean herb', 'herbs');
    $ing_db['duck_breast'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'duck breast', 'Rich, dark, fat-capped poultry meat', 'meat');
    $ing_db['duck_fat'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'duck fat', 'Rendered fat prized for roasting golden potatoes', 'oils');
    $ing_db['edamame_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'edamame beans', 'Immature green soybeans inside or outside the pod', 'produce');
    $ing_db['elderflower_cordial'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'elderflower cordial', 'Sweet, floral syrup infusion from elderflower blossoms', 'beverages');
    $ing_db['english_mustard'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'english mustard', 'Very hot, sharp yellow mustard paste paste', 'condiments');
    $ing_db['espresso'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'espresso', 'Strong brewed espresso coffee', 'pantry');
    $ing_db['evaporated_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'evaporated_milk', 'Unsweetened canned milk with 60 percent water removed', 'baking');
    $ing_db['fennel_bulb'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fennel bulb', 'Crisp, anise-flavored layered white vegetable bulb', 'produce');
    $ing_db['fennel_seed'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fennel seed', 'Whole fennel seeds', 'spices');
    $ing_db['fenugreek_ground'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground fenugreek', 'Bitter-sweet, maple-scented ground legume spice powder', 'spices');
    $ing_db['feta_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'feta cheese', 'Brined curd white cheese from sheep and goat milk', 'dairy');
    $ing_db['figs_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh figs', 'Sweet, teardrop-shaped fruits with soft seedy flesh', 'produce');
    $ing_db['finger_biscuits'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'finger biscuits', 'Sweet ladyfinger biscuits', 'bakery');
    $ing_db['fish_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fish sauce', 'Salty, fermented anchovy liquid condiment', 'condiments');
    $ing_db['flax_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'flaxseeds', 'Nutritious linseed oilseeds frequently used as egg replacers', 'seeds');
    $ing_db['floret_broccoli'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'floret broccoli', 'Fresh broccoli florets', 'vegetable');
    $ing_db['french_mustard'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'french mustard', 'Mild, dark brown vinegar-forward mustard preparation', 'condiments');
    $ing_db['fresh_basil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh basil', 'Fragrant fresh basil leaves', 'vegetable');
    $ing_db['fresh_chilli'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh chilli', 'Raw red or green hot pepper pod', 'produce');
    $ing_db['fresh_ginger'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh ginger', 'Fresh ginger root', 'vegetable');
    $ing_db['fresh_mint'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh mint', 'Cool fresh mint leaves', 'vegetable');
    $ing_db['fresh_parsley'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh parsley', 'Flat-leaf or curly raw parsley sprigs', 'herbs');
    $ing_db['fresh_rosemary'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh rosemary', 'Needle-like woody aromatic herb sprigs', 'herbs');
    $ing_db['frozen_peas'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'frozen peas', 'Sweet frozen peas', 'vegetable');
    $ing_db['gala_apples'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gala apples', 'Sweet, crisp red-yellow snacking apples', 'produce');
    $ing_db['galangal_root'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'galangal', 'Sharp, citrusy rhizome resembling ginger used in Thai cuisine', 'produce');
    $ing_db['garam_masala'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garam masala', 'Aromatic garam masala spice blend', 'spices');
    $ing_db['garlic_cloves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garlic cloves', 'Fresh garlic cloves', 'vegetable');
    $ing_db['garlic_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garlic paste', 'Blended, puréed garlic cloves often preserved in oil', 'condiments');
    $ing_db['garlic_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'garlic powder', 'Dehydrated, finely pulverized garlic granules', 'spices');
    $ing_db['ghee'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ghee', 'Clarified butter simmered to remove water and toast solids', 'oils');
    $ing_db['gherkins_pickled'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pickled gherkins', 'Small, crisp cucumbers preserved in vinegar and dill', 'condiments');
    $ing_db['ginger_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ginger paste', 'Puréed fresh ginger root used for easy curry assembly', 'condiments');
    $ing_db['gnocchi'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gnocchi', 'Soft potato gnocchi', 'pantry');
    $ing_db['goats_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'goats cheese', 'Tangy cheese varieties made from goat milk', 'dairy');
    $ing_db['golden_granulated_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'golden granulated sugar', 'Unrefined white sugar option maintaining a slight blonde molasses trace', 'baking');
    $ing_db['golden_syrup'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'golden syrup', 'Sweet golden syrup', 'pantry');
    $ing_db['goose_fat'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'goose fat', 'Rich rendered fat traditional for roast dinner potatoes', 'oils');
    $ing_db['gooseberries'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gooseberries', 'Tart, furry green summer orchard berries', 'produce');
    $ing_db['gorgonzola'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gorgonzola', 'Veined Italian blue cheese made from unskimmed cow milk', 'dairy');
    $ing_db['granulated_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'granulated sugar', 'Standard refined white sugar crystals for everyday sweetening', 'baking');
    $ing_db['grape_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'grape juice', 'Sweet unfermented beverage pressed from whole grapes', 'beverages');
    $ing_db['grapefruit'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'grapefruit', 'Large, bitter-sweet citrus fruit with pink or yellow flesh', 'produce');
    $ing_db['grapeseed_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'grapeseed oil', 'Neutral, clean-burning oil pressed from grape seeds', 'oils');
    $ing_db['greek_yogurt'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'greek yogurt', 'Thick Greek yogurt', 'dairy');
    $ing_db['green_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green beans', 'Fresh green beans', 'vegetable');
    $ing_db['green_cabbage'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green cabbage', 'Smooth-leafed tightly packed green head vegetable', 'produce');
    $ing_db['green_olives'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green olives', 'Firm, unripe pickled whole olives', 'condiments');
    $ing_db['green_peppercorns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green peppercorns', 'Brined or dried mild immature peppercorn berries', 'spices');
    $ing_db['ground_almonds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground almonds', 'Finely milled blanched sweet almonds', 'baking');
    $ing_db['ground_black_pepper'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground black pepper', 'Ground black pepper', 'spices');
    $ing_db['ground_cinnamon'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground cinnamon', 'Ground sweet cinnamon', 'spices');
    $ing_db['ground_coriander'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground coriander', 'Ground coriander seeds', 'spices');
    $ing_db['ground_cumin'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground cumin', 'Ground cumin seeds', 'spices');
    $ing_db['ground_ginger'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground ginger', 'Dried, pulverized ginger root powder', 'spices');
    $ing_db['ground_nutmeg'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground nutmeg', 'Ground aromatic nutmeg', 'spices');
    $ing_db['gruyere_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'gruyere cheese', 'Swiss Gruyère cheese', 'dairy');
    $ing_db['haddock_fillet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'haddock fillet', 'Popular North Atlantic white marine food fish', 'seafood');
    $ing_db['halloumi'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'halloumi cheese', 'Semi-hard, brined Cypriot cheese with a high melting point ideal for grilling', 'dairy');
    $ing_db['harissa_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'harissa paste', 'Tunisian hot chilli pepper paste seasoned with coriander and caraway', 'condiments');
    $ing_db['hazelnuts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'hazelnuts', 'Round cobnuts harvested from the hazel tree', 'nuts');
    $ing_db['hemp_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'hemp seeds', 'Nutty, high-protein shelled seeds of the hemp plant', 'seeds');
    $ing_db['herbes_de_provence'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'herbes de provence', 'French herb mixture containing rosemary, thyme, oregano, and lavender', 'herbs');
    $ing_db['hoisin_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'hoisin sauce', 'Thick, sweet, fragrant Chinese sauce based on fermented soy', 'condiments');
    $ing_db['honey'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'honey', 'Sweet, viscous liquid food made by bees', 'sweeteners');
    $ing_db['horseradish_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'horseradish sauce', 'Pungent condiment combining grated horseradish root and cream', 'condiments');
    $ing_db['iceberg_lettuce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'iceberg lettuce', 'Crisp iceberg lettuce', 'vegetable');
    $ing_db['icing_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'icing sugar', 'Finely powdered white confectionery sugar', 'baking');
    $ing_db['jalapeno_peppers'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'jalapeno peppers', 'Medium-sized hot green chilli pepper pods', 'produce');
    $ing_db['jasmine_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'jasmine rice', 'Long-grain fragrant varieties of rice', 'grains');
    $ing_db['jerk_seasoning'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'jerk seasoning', 'Jamaican allspice and scotch bonnet pepper dry seasoning blend', 'spices');
    $ing_db['juniper_berries'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'juniper berries', 'Piny, aromatic dried seed cones of the juniper bush', 'spices');
    $ing_db['kale_leaves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'kale', 'Fibrous, dark green ruffled cruciferous leaves', 'produce');
    $ing_db['katsu_curry_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'katsu curry paste', 'Mild, aromatic Japanese style spiced curry base', 'condiments');
    $ing_db['kidney_beans_canned'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'canned kidney beans', 'Red beans preserved in water ready for chilli dishes', 'canned');
    $ing_db['king_prawns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'king prawns', 'Large, sweet decapod crustaceans common to UK seafood counters', 'seafood');
    $ing_db['lamb_chops'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lamb chops', 'Bone-in tender cuts of lamb loin or rib', 'meat');
    $ing_db['lamb_mince'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lamb mince', 'Ground raw lamb meat', 'meat');
    $ing_db['lard'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lard', 'Rendered pork fat prized for flaky pastry doughs', 'oils');
    $ing_db['large_eggs'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'large eggs', 'Large free-range eggs', 'dairy');
    $ing_db['large_potatoes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'large potatoes', 'Large baking potatoes', 'vegetable');
    $ing_db['lasagna_pasta'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lasagne sheets', 'Flat, wide dried pasta rectangles for layering', 'pasta');
    $ing_db['lavender_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried lavender', 'Culinary grade sweet floral buds', 'herbs');
    $ing_db['leeks'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'leeks', 'Fresh sliced leeks', 'vegetable');
    $ing_db['lemon_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lemon juice', 'Freshly squeezed lemon juice', 'pantry');
    $ing_db['lemongrass_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lemongrass paste', 'Ground fibrous stalks of the lemon grass plant', 'condiments');
    $ing_db['lemongrass_stalks'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'lemongrass stalks', 'Fresh aromatic citrus stems key to Southeast Asian cooking', 'produce');
    $ing_db['lentils_brown'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'brown lentils', 'Versatile earthy pulses that retain shape during stewing', 'pulses');
    $ing_db['lentils_green'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green lentils', 'Firm, peppery French-style small legumes', 'pulses');
    $ing_db['lentils_red'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red lentils', 'Split pulses that dissolve quickly to thicken dhal and soups', 'pulses');
    $ing_db['light_brown_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'light brown soft sugar', 'Fine sugar with a delicate coating of cane syrups', 'baking');
    $ing_db['light_soy_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'light soy sauce', 'Thin, highly salty fermented soy condiment', 'condiments');
    $ing_db['limes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'limes', 'Tart, green citrus fruits', 'produce');
    $ing_db['linguine_pasta'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'linguine', 'Long, flat ribbon strands of dried pasta', 'pasta');
    $ing_db['liquid_smoke'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'liquid smoke', 'Water-soluble condensate of natural wood smoke fumes', 'condiments');
    $ing_db['mace_ground'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ground mace', 'Warm spice powder produced from the lacy outer hull of nutmeg', 'spices');
    $ing_db['mackerel_fillets'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mackerel fillets', 'Oily, rich, omega-dense ocean fish cuts', 'seafood');
    $ing_db['malt_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'malt vinegar', 'Pungent, dark vinegar brewed from malted barley grains', 'condiments');
    $ing_db['manchego'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'manchego cheese', 'Firm, sweet Spanish cheese crafted from sheep milk', 'dairy');
    $ing_db['mango_chutney'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mango chutney', 'Sweet mango chutney', 'sauce');
    $ing_db['mango_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh mango', 'Sweet tropical stone fruit with juicy orange flesh', 'produce');
    $ing_db['maple_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'maple sugar', 'Granulated solid sweetener achieved by boiling maple sap', 'sweeteners');
    $ing_db['maple_syrup'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'maple_syrup', 'Pure sweet syrup reduced from maple tree sap', 'sweeteners');
    $ing_db['marjoram_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried marjoram', 'Sweet, pine-citrus herb relative of oregano', 'herbs');
    $ing_db['marmalade_orange'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'orange marmalade', 'Bitter-sweet citrus preserve featuring boiled orange rinds', 'condiments');
    $ing_db['marmite_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'marmite', 'Traditional salty, savory British yeast extract spread', 'condiments');
    $ing_db['marshmallows'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'marshmallows', 'Spongy confectionery made from sugar, corn syrup, and gelatine', 'sweeteners');
    $ing_db['marzipan'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'marzipan', 'Sweet paste combining ground almonds, sugar, and egg binders', 'baking');
    $ing_db['mascarpone'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mascarpone', 'Creamy Italian mascarpone', 'dairy');
    $ing_db['matzo_meal'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'matzo meal', 'Ground unleavened flatbread cracker crumbs', 'baking');
    $ing_db['mayonaisse'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mayonaisse', 'Creamy mayonnaise', 'sauce');
    $ing_db['meringue_nests'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'meringue nests', 'Crispy baked egg white and sugar confection cups', 'bakery');
    $ing_db['mild_curry_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mild curry powder', 'Mild curry powder blend', 'spices');
    $ing_db['milk_skimmed'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'skimmed milk', 'Cow milk with virtually all cream fats spun out', 'dairy');
    $ing_db['mint_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mint sauce', 'Finely chopped spearmint steeped in vinegar and sugar', 'condiments');
    $ing_db['miso_paste_red'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red miso paste', 'Long-fermented deep, salty umami soybean paste', 'condiments');
    $ing_db['miso_paste_white'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white miso paste', 'Sweet, mild fermented Japanese soybean paste', 'condiments');
    $ing_db['mixed_peeled_fruit'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mixed dried fruit', 'Standard UK blend of raisins, sultanas, currants, and peel', 'baking');
    $ing_db['mixed_spice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mixed spice', 'Classic British sweet baking blend of cinnamon, nutmeg, and allspice', 'spices');
    $ing_db['molasses_unrefined'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'molasses', 'Thick, dark syrup extraction remaining after sugar refinement', 'sweeteners');
    $ing_db['monks_fruit_sweetener'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'monk fruit sweetener', 'Zero-calorie sugar substitute derived from luo han guo', 'sweeteners');
    $ing_db['mozzarella_ball'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mozzarella ball', 'Fresh mozzarella cheese ball', 'dairy');
    $ing_db['mozzarella_shredded'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'grated mozzarella', 'Low-moisture shredded cheese suited for pizzas', 'dairy');
    $ing_db['muscovado_sugar_dark'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dark muscovado sugar', 'Unrefined functional cane sugar rich in deep smoky molasses', 'baking');
    $ing_db['muscovado_sugar_light'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'light muscovado sugar', 'Moist unrefined sugar displaying soft caramel notes', 'baking');
    $ing_db['mushrooms'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mushrooms', 'Standard white, chestnut, or button edible fungi', 'produce');
    $ing_db['mussels_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh mussels', 'Live black-shelled marine bivalve molluscs', 'seafood');
    $ing_db['mustard_grain'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'wholegrain mustard', 'Mild mustard paste retaining crushed whole seeds', 'condiments');
    $ing_db['mustard_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'mustard seeds', 'Small round seeds of the mustard plant', 'spices');
    $ing_db['naan_bread'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'naan bread', 'Leavened, yogurt-enriched flatbread baked in a tandoor', 'bakery');
    $ing_db['nigella_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'nigella seeds', 'Small black aromatic seeds with an onion-oregano profile', 'spices');
    $ing_db['nori_sheets'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'nori sheets', 'Dried, pressed sheets of edible seaweed for sushi wrappers', 'pantry');
    $ing_db['nutritional_yeast'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'nutritional yeast', 'Deactivated savory yeast flakes used for cheese alternative flavoring', 'dairy-free');
    $ing_db['oat_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'oat flour', 'Finely ground whole grain rolled oats', 'baking');
    $ing_db['oat_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'oat milk', 'Plant-based milk substitute derived from whole oats', 'dairy-free');
    $ing_db['oil_avocado'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'avocado oil', 'High smoke point monounsaturated fruit cooking oil', 'oils');
    $ing_db['oil_sesame_toasted'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'toasted sesame oil', 'Dark aromatic finishing oil pressed from roasted sesame seeds', 'oils');
    $ing_db['oil_walnut'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'walnut oil', 'Nutty, delicate finishing oil cold-pressed from walnuts', 'oils');
    $ing_db['okra'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'okra', 'Mucilaginous green seed pods prized in stews and gumbos', 'produce');
    $ing_db['olive_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'olive oil', 'Extra virgin olive oil', 'pantry');
    $ing_db['olive_oil_extra_virgin'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'extra virgin olive oil', 'Cold-pressed, unrefined premium olive oil for raw dressings', 'oils');
    $ing_db['onion_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'onion powder', 'Dehydrated, finely ground culinary onions', 'spices');
    $ing_db['onion_red'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red onion', 'Sweet mild onion variety featuring purplish skins', 'produce');
    $ing_db['orange_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'orange juice', 'Sweet liquid refreshment expressed from whole oranges', 'beverages');
    $ing_db['orange_peel_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'orange zest', 'Grated outer aromatic colorful skin of raw oranges', 'produce');
    $ing_db['oregano_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh oregano', 'Raw green leaves of the pungent Mediterranean herb', 'herbs');
    $ing_db['oyster_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'oyster sauce', 'Sweet and savory dark condiment reduced from oyster extracts', 'condiments');
    $ing_db['oysters_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh oysters', 'Premium live saltwater bivalves eaten raw from the shell', 'seafood');
    $ing_db['paella_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'paella rice', 'Short-grain paella rice', 'pantry');
    $ing_db['palm_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'palm oil', 'Edible vegetable oil derived from the mesocarp of oil palms', 'oils');
    $ing_db['palm_sugar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'palm sugar', 'Sweetener derived from sap extractions of various palm trees', 'sweeteners');
    $ing_db['pancetta'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pancetta', 'Italian salt-cured pork belly meat', 'meat');
    $ing_db['paneer'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'paneer', 'Non-melting acid-set unaged curd cheese native to India', 'dairy');
    $ing_db['paprika'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'paprika', 'Mild, ground sweet pepper powder spice', 'spices');
    $ing_db['parmesan_reggiano'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'parmigiano-reggiano', 'DOP protected hard, granular aged northern Italian cheese', 'dairy');
    $ing_db['parsley_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried parsley', 'Flakes of dehydrated parsley leaves', 'herbs');
    $ing_db['parsnips'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'parsnips', 'Sweet pale winter root vegetable closely related to carrots', 'produce');
    $ing_db['passion_fruit'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'passion fruit', 'Tropical purple fruit containing sweet, aromatic gelatinous seeds', 'produce');
    $ing_db['pasta_penne'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'penne pasta', 'Cylinder-shaped tubes of dried durum wheat pasta', 'pasta');
    $ing_db['pasta_spaghetti'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spaghetti', 'Classic long, thin cylindrical cords of dried pasta', 'pasta');
    $ing_db['pastry_puff'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'puff pastry', 'Laminated flakey dough utilizing alternating fat layers', 'baking');
    $ing_db['pastry_shortcrust'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'shortcrust pastry', 'Crumbly, dense pie dough compound omitting leaveners', 'baking');
    $ing_db['peanut_butter'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'peanut butter', 'Smooth or crunchy roasted peanut paste spread', 'spreads');
    $ing_db['peanuts_roasted'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'roasted peanuts', 'De-shelled roasted groundnuts suitable for snacks or sauces', 'nuts');
    $ing_db['pear_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pear juice', 'Sweet, mellow juice pressed from fresh orchard pears', 'beverages');
    $ing_db['pears_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh pears', 'Sweet, narrow-necked deciduous orchard fruits', 'produce');
    $ing_db['pecans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pecan nuts', 'Rich, sweet hickory nuts cultivated in North America', 'nuts');
    $ing_db['pecorino_romano'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pecorino romano', 'Hard, salty Italian cheese crafted from sheep milk', 'dairy');
    $ing_db['peppercorns_pink'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pink peppercorns', 'Sweet, fragile dried berries of the Peruvian pepper tree', 'spices');
    $ing_db['peppercorns_white'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white peppercorns', 'Fully ripened peppercorn seeds stripped of dark outer skins', 'spices');
    $ing_db['peppermint_extract'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'peppermint extract', 'Concentrated culinary essential oils of peppermint leaves', 'baking');
    $ing_db['pesto_green'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'green pesto', 'Traditional sauce combining crushed basil, pine nuts, garlic, and parmesan', 'condiments');
    $ing_db['pesto_red'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red pesto', 'Rich condiment paste based on sun-dried tomatoes and oils', 'condiments');
    $ing_db['phyllo_pastry'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'phyllo pastry', 'Paper-thin phyllo pastry sheets', 'bakery');
    $ing_db['piccalilli_pickle'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'piccalilli', 'British relish of mustard, turmeric, and pickled vegetables', 'condiments');
    $ing_db['pickling_spice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pickling spice', 'Coarse mixture of mustard seeds, dill, coriander, and bay', 'spices');
    $ing_db['pine_nuts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pine nuts', 'Small, edible seeds harvested from pine cones', 'nuts');
    $ing_db['pine_nuts_toasted'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'toasted pine nuts', 'Lightly browned pine kernels developing deep nutty oils', 'nuts');
    $ing_db['pineapple_canned'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'canned pineapple', 'Pineapple chunks or rings preserved in juice containers', 'canned');
    $ing_db['pineapple_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh pineapple', 'Large spiky tropical fruit containing sweet yellow flesh', 'produce');
    $ing_db['pinto_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pinto beans', 'Speckled pulses ubiquitous in Mexican refried bean variants', 'pulses');
    $ing_db['pistachios'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pistachio nuts', 'Green-kernelled culinary tree nuts encased in tan shells', 'nuts');
    $ing_db['pita_bread'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pita bread', 'Soft pita bread pockets', 'bakery');
    $ing_db['plain_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'plain flour', 'All-purpose plain flour', 'pantry');
    $ing_db['plum_tomatoes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'plum tomatoes', 'Oval-shaped tomatoes with low water content', 'produce');
    $ing_db['plums_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh plums', 'Sweet purple or red stone fruits from deciduous orchard trees', 'produce');
    $ing_db['pomegranate_molasses'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pomegranate molasses', 'Thick, tart syrup reduced from sweet pomegranate juices', 'condiments');
    $ing_db['pomegranate_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pomegranate seeds', 'Juicy, ruby-red tart arils harvested from pomegranate fruits', 'produce');
    $ing_db['poppy_seed_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'poppy seed paste', 'Sweetened ground poppy seed filling for European pastries', 'baking');
    $ing_db['poppy_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'poppy seeds', 'Tiny oilseeds harvested from opium poppies', 'baking');
    $ing_db['pork_belly'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork belly', 'Boneless, fatty cut of meat taken from the underside of the pig', 'meat');
    $ing_db['pork_chops'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork chops', 'Loin cuts of raw pork containing structural rib bones', 'meat');
    $ing_db['pork_loin'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork loin', 'Tender pork loin medallions', 'meat');
    $ing_db['pork_mince'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork mince', 'Lean minced pork', 'meat');
    $ing_db['pork_sausages'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pork sausages', 'Premium pork sausages', 'meat');
    $ing_db['potato_starch'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'potato starch', 'Gluten-free thickening extract obtained from tuber cell structures', 'baking');
    $ing_db['potatoes_king_edward'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'king edward potatoes', 'Traditional British baking potato with light pink structural patches', 'produce');
    $ing_db['potatoes_maris_piper'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'maris piper potatoes', 'Floury UK potato variety supreme for chipping and roasting', 'produce');
    $ing_db['potatoes_sweet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sweet potatoes', 'Starchy orange-fleshed tuberous root vegetables', 'produce');
    $ing_db['poultry_seasoning'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'poultry seasoning', 'Sage and thyme forward roasting dry herb blend', 'spices');
    $ing_db['prawns_tiger'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'raw tiger prawns', 'Grey shell-on raw tropical jumbo prawns', 'seafood');
    $ing_db['prosciutto_di_parma'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'prosciutto', 'Thinly sliced dry-cured Italian uncooked ham', 'meat');
    $ing_db['prunes_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'prunes', 'Dehydrated sweet whole or pitted plums', 'pantry');
    $ing_db['pumpkin_puree'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'canned pumpkin', 'Unsweetened cooked pumpkin pulp used for pie baking', 'canned');
    $ing_db['pumpkin_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pumpkin seeds', 'Edible hulled green seeds also known as pepitas', 'seeds');
    $ing_db['quarg_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'quark', 'Smooth, fat-free spoonable European curd cheese', 'dairy');
    $ing_db['quinoa'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'quinoa', 'Nutritious, high-protein pseudocereal grains', 'grains');
    $ing_db['quinoa_white'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'quinoa', 'High-protein grain-like seed originating from the Andes', 'grains');
    $ing_db['radicchio'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'radicchio', 'Bitter leaf chicory featuring red leaves with white veins', 'produce');
    $ing_db['radishes_red'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'radishes', 'Crisp, peppery small red salad root vegetables', 'produce');
    $ing_db['raisins_sultana'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sultanas', 'Dried golden seedless grapes popular in British cakes', 'baking');
    $ing_db['raisins_thompson'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'raisins', 'Dark dried grapes possessing a rich sweet flavor profiles', 'baking');
    $ing_db['ras_el_hanout'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ras el hanout', 'Complex North African spice blend containing cardamom, clove, and chili', 'spices');
    $ing_db['raspberries_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh raspberries', 'Sweet tart hollow red aggregate summer fruits', 'produce');
    $ing_db['raw_prawns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'raw prawns', 'Fresh raw prawns', 'seafood');
    $ing_db['red_bell_pepper'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red bell pepper', 'Sweet red bell pepper', 'vegetable');
    $ing_db['red_cabbage'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red cabbage', 'Dense purple-red cabbage head prized for pickling or braising', 'produce');
    $ing_db['red_chilli_powder'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'chilli powder', 'Pure ground hot red pepper pods lacking added cumin salts', 'spices');
    $ing_db['red_currant_jelly'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'redcurrant jelly', 'Sweet, clear ruby preserve traditional with roast lamb dinners', 'condiments');
    $ing_db['red_currants_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh redcurrants', 'Tart glossy translucent red berries growing in clusters', 'produce');
    $ing_db['red_kidney_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red kidney beans', 'Tinned red kidney beans', 'pantry');
    $ing_db['red_onion'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red onion', 'Mild red onion', 'vegetable');
    $ing_db['red_pepper_flakes'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'crushed chilli flakes', 'Dried fiery pepper seeds and skins', 'spices');
    $ing_db['red_wine'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red wine', 'Rich and sweeter than a white wine', 'drinks');
    $ing_db['red_wine_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'red wine vinegar', 'Sharp vinegar fermented from red grape varieties', 'condiments');
    $ing_db['rhubarb_stalks'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rhubarb', 'Sour pink perennial vegetable stems cooked into sweet crumbles', 'produce');
    $ing_db['rice_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rice flour', 'Finely ground grains of white or brown rice', 'baking');
    $ing_db['rice_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rice vinegar', 'Mild vinegar brewed from fermented Asian rices', 'condiments');
    $ing_db['rice_wine_shaoxing'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'shaoxing rice wine', 'Traditional Chinese amber cooking wine derived from fermented glutinous rice', 'alcohol');
    $ing_db['ricotta_cheese'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'ricotta cheese', 'Creamy Italian whey cheese used in pasta fillings', 'dairy');
    $ing_db['rigatoni_pasta'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rigatoni', 'Large ridged cylindrical tubes of dried pasta', 'pasta');
    $ing_db['rock_salt'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'coarse rock salt', 'Mined mineral sodium chloride crystals', 'spices');
    $ing_db['rolled_oats'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rolled oats', 'De-husked, steamed and flattened oat groats', 'grains');
    $ing_db['rosemary_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried rosemary', 'Dehydrated needle leaves of the aromatic rosemary bush', 'herbs');
    $ing_db['rum_dark'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dark rum', 'Aged sugarcane molasses spirit used in pastry glazes', 'alcohol');
    $ing_db['rye_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rye flour', 'Milled flour of rye grains central to dense sourdoughs', 'baking');
    $ing_db['saffron'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'saffron', 'Precious saffron threads', 'spices');
    $ing_db['sage_dried'] =     new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dried sage', 'Powdered or flaked velvety leaves of culinary sage plants', 'herbs');
    $ing_db['sage_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh sage', 'Raw velvety grey-green leaves traditional in holiday stuffing', 'herbs');
    $ing_db['sake_cooking'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sake', 'Japanese alcoholic beverage brewed from polished rice grains', 'alcohol');
    $ing_db['salad_cream'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'salad cream', 'Classic British emulsion condiment featuring vinegar and egg yolk bases', 'condiments');
    $ing_db['salami_slices'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'salami', 'Cured, air-dried fermented pork sausage discs', 'meat');
    $ing_db['salmon_fillet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'salmon fillet', 'Fresh salmon fillets', 'seafood');
    $ing_db['salmon_smoked'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'smoked salmon', 'Oak-smoked or salt-cured cold orange salmon ribbons', 'seafood');
    $ing_db['sambal_oelek'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sambal oelek', 'Indonesian raw crushed chilli paste omitting sweet fillers', 'condiments');
    $ing_db['sardines_canned'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'canned sardines', 'Small whole oily fish preserved in sunflower oils or tomato sauces', 'canned');
    $ing_db['sausages_cumberland'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'cumberland sausages', 'Peppery pork sausage traditional to northern English counties', 'meat');
    $ing_db['scallops_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh scallops', 'Sweet marine bivalve molluscs displaying tender white flesh cords', 'seafood');
    $ing_db['scotch_bonnet_chilli'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'scotch bonnet chilli', 'Extremely spicy Caribbean pepper pods central to jerk marinades', 'produce');
    $ing_db['sea_salt'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sea salt', 'Fine sea salt', 'spices');
    $ing_db['seafood_cocktail_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'marie rose sauce', 'Classic British prawn cocktail dressing of mayo, ketchup, and cayenne', 'condiments');
    $ing_db['self_raising_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'self-raising flour', 'Wheat flour pre-blended with chemical leavening agents', 'baking');
    $ing_db['semolina'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'semolina', 'Coarse middlings of durum wheat used for gnocchi and puddings', 'baking');
    $ing_db['sesame_seeds_black'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'black sesame seeds', 'Unskinned nutty oilseeds used for sushi visual contrasts', 'seeds');
    $ing_db['sesame_seeds_white'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white sesame seeds', 'Hulled tear-shaped sweet nutty oilseeds', 'seeds');
    $ing_db['shallots'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'shallots', 'Small clustered sweet onion varieties with delicate structural layers', 'produce');
    $ing_db['sherry_dry'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'dry sherry', 'Fortified Spanish white grape wine supreme for pan sauces', 'alcohol');
    $ing_db['shiso_leaves'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'shiso leaves', 'Aromatic Japanese perilla mint herb leaves', 'herbs');
    $ing_db['smoked_paprika'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'smoked paprika', 'Smoky red paprika', 'spices');
    $ing_db['sour_cream'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sour cream', 'Dairy cream fermented with lactic acid bacteria', 'dairy');
    $ing_db['soy_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'soy milk', 'Plant-based liquid extract from soybeans', 'dairy-free');
    $ing_db['soy_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'soy sauce', 'Savory soy sauce', 'sauce');
    $ing_db['spinach'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spinach', 'Fresh baby spinach leaves', 'vegetable');
    $ing_db['spring_onion'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spring onion', 'Fresh spring onions', 'vegetable');
    $ing_db['spring_roll_wrappers'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'spring roll wrappers', 'Crispy spring roll wrappers', 'bakery');
    $ing_db['sriracha_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sriracha', 'Garlic-forward Thai fermented hot chilli table sauce', 'condiments');
    $ing_db['star_anise_ground'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'star anise powder', 'Pulverized star anise pods delivering sweet licorice outputs', 'spices');
    $ing_db['steak_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'steak sauce', 'Tangy savory table condiment for grilled cuts', 'condiments');
    $ing_db['stilton_blue'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'stilton cheese', 'Iconic British semi-hard blue-veined cow milk cheese', 'dairy');
    $ing_db['strawberries_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh strawberries', 'Sweet glossy red summer aggregate berries', 'produce');
    $ing_db['strong_bread_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'strong bread flour', 'Strong white bread flour', 'pantry');
    $ing_db['suet_beef'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'beef suet', 'Raw shredded kidney fat traditional for British savory puddings', 'baking');
    $ing_db['suet_vegetable'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable suet', 'Solid fat alternative based on oils and wheat flours', 'baking');
    $ing_db['sugar_fondant'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fondant icing', 'Pliable sugar paste used for draping celebration cakes', 'baking');
    $ing_db['sugar_nibbed'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'pearl sugar', 'Crushed blocks of refined sugar that resist melting when baked', 'baking');
    $ing_db['sumac_spice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sumac', 'Tangy, astringent crimson spice berry powder from the Middle East', 'spices');
    $ing_db['sunflower_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sunflower oil', 'Pure sunflower oil', 'pantry');
    $ing_db['sunflower_seeds'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sunflower seeds', 'Hulled edible seeds harvested from sunflower disks', 'seeds');
    $ing_db['sweet_corn'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sweet corn', 'Canned, frozen, or fresh yellow maize kernels', 'produce');
    $ing_db['sweet_potato_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sweet potato flour', 'Dehydrated ground sweet potato starches', 'baking');
    $ing_db['szechuan_peppercorns'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'szechuan peppercorns', 'Numbing pink seed husks harvested from the prickly ash tree', 'spices');
    $ing_db['tahini'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tahini', 'Smooth paste made from toasted hulled sesame seeds', 'condiments');
    $ing_db['tamarind_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tamarind paste', 'Sour, sticky concentrate extracted from pod fruits of the tamarind tree', 'condiments');
    $ing_db['tarragon_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh tarragon', 'Slender green leaves delivering clean liquorice aromatic signatures', 'herbs');
    $ing_db['tea_earl_grey'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'earl grey tea leaves', 'Black tea scented with essential oils of bergamot orange skins', 'pantry');
    $ing_db['thyme_fresh'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'fresh thyme', 'Earthy sprigs containing tiny woody Mediterranean leaves', 'herbs');
    $ing_db['tinned_peaches'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tinned peaches', 'Sweet tinned peach slices', 'fruit');
    $ing_db['tofu_firm'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'firm tofu', 'Coagulated soy milk pressed into sliceable blocks', 'dairy-free');
    $ing_db['tofu_silken'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'silken tofu', 'Undrained, smooth custard-like soy curd matrices', 'dairy-free');
    $ing_db['toma_sun_dried'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'sun-dried tomatoes', 'Intense dehydrated tomatoes preserved in oil canisters', 'pantry');
    $ing_db['tomato'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato', 'Ripe red tomatoes', 'vegetable');
    $ing_db['tomato_ketchup'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato ketchup', 'Sweet and tangy tomato-based table condiment', 'condiments');
    $ing_db['tomato_passata'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato passata', 'Smooth tomato passata', 'sauce');
    $ing_db['tomato_puree'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tomato puree', 'Rich concentrated tomato puree', 'sauce');
    $ing_db['tonka_beans'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tonka beans', 'Wrinkled black seeds boasting an intense vanilla-almond aroma', 'spices');
    $ing_db['tortilla_wraps'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tortilla wraps', 'Soft, flat thin round flatbreads', 'bakery');
    $ing_db['tuna_steak'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'tuna steak', 'Fresh tuna steaks', 'seafood');
    $ing_db['turkey_breast'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turkey breast', 'Tender turkey breast fillets', 'meat');
    $ing_db['turkey_mince'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turkey mince', 'Lean ground raw turkey breast and thigh meat', 'meat');
    $ing_db['turmeric'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turmeric', 'Ground yellow turmeric powder', 'spices');
    $ing_db['turnips'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'turnips', 'Sharp white and purple round brassica root vegetables', 'produce');
    $ing_db['vanilla_extract'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vanilla extract', 'Pure solution extracted from whole orchid pods using alcohol', 'baking');
    $ing_db['vanilla_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vanilla bean paste', 'Concentrated extract suspended with visible dark pod seeds', 'baking');
    $ing_db['vanilla_pod'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vanilla pod', 'Whole aromatic seed pods of the vanilla orchid', 'baking');
    $ing_db['veal_cutlet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'veal cutlet', 'Lean, tender sliced cut from the leg of young cattle', 'meat');
    $ing_db['vegemite_paste'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegemite', 'Salty Australian yeast extract table spread alternative', 'condiments');
    $ing_db['vegetable_oil'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable oil', 'All-purpose vegetable oil', 'pantry');
    $ing_db['vegetable_stock'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vegetable stock', 'Liquid vegetable stock', 'pantry');
    $ing_db['venison_haunch'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'venison haunch', 'Lean, rich game meat cut from deer hind quarters', 'meat');
    $ing_db['verjuice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'verjuice', 'Highly acidic juice pressed from unripe green grapes', 'condiments');
    $ing_db['vermicelli_rice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'rice vermicelli', 'Very thin round noodles crafted from rice starches', 'pasta');
    $ing_db['vodka'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'vodka', 'Clear neutral distilled spirit ideal for structural pie crust elements', 'alcohol');
    $ing_db['walnuts'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'walnuts', 'Wrinkled tree nut kernels rich in oils', 'nuts');
    $ing_db['white_bread'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white bread', 'Sliced white bread', 'bakery');
    $ing_db['white_fish_fillet'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white fish fillet', 'Fresh white fish fillets', 'seafood');
    $ing_db['white_onion'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white onion', 'Mild white onion', 'vegetable');
    $ing_db['white_wine'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white wine', 'Dry or sweet alcoholic wine from green grapes', 'alcohol');
    $ing_db['white_wine_vinegar'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'white wine vinegar', 'Acidic table vinegar fermented from white wine', 'condiments');
    $ing_db['whole_lemon'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole lemon', 'Fresh whole lemon', 'fruit');
    $ing_db['whole_milk'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole milk', 'Whole dairy milk', 'dairy');
    $ing_db['whole_nutmeg'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'whole nutmeg', 'Hard aromatic inner seed of the nutmeg tree fruit', 'spices');
    $ing_db['wholemeal_flour'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'wholemeal flour', 'Coarse flour milled from whole wheat grains', 'baking');
    $ing_db['wonton_wrappers'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'wonton wrappers', 'Thin squares of wheat egg dough for dumpling assemblies', 'pasta');
    $ing_db['worcestershire_sauce'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'worcestershire sauce', 'Fermented liquid condiment with anchovy base', 'condiments');
    $ing_db['xanthan_gum'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'xanthan gum', 'Polysaccharide powder used to bind gluten-free baked formulations', 'baking');
    $ing_db['yuzu_juice'] = new Ingredient(new_uuid('ingredient_id', 'Ingredients'), 'yuzu juice', 'Intensely fragrant tart juice of the East Asian citrus fruit', 'condiments');

    foreach ($ing_db as $key => $ingredient) {
        $ingredient->create();
    }

    #endregion ingredients


    #region allergies

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

    $gluten_ingredients = [
        'barley_pearl',
        'black_pudding',
        'bread_crumbs_panko',
        'breadcrumbs',
        'bulgur_wheat',
        'burger_buns',
        'couscous',
        'finger_biscuits',
        'hoisin_sauce',
        'lasagna_pasta',
        'light_soy_sauce',
        'linguine_pasta',
        'malt_vinegar',
        'matzo_meal',
        'naan_bread',
        'oat_flour',
        'oat_milk',
        'pasta_penne',
        'pasta_spaghetti',
        'pastry_puff',
        'pastry_shortcrust',
        'penne',
        'pita_bread',
        'pitta_breads',
        'plain_flour',
        'plain_flour_white',
        'rice_wine_shaoxing',
        'rigatoni_pasta',
        'rolled_oats',
        'rye_flour',
        'self_raising_flour',
        'semolina',
        'soy_sauce',
        'spring_roll_wrappers',
        'strong_bread_flour',
        'tortilla_wraps',
        'white_bread',
        'wholemeal_flour',
        'wonton_wrappers',
        'worcestershire_sauce'
    ];
    foreach ($gluten_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_cereals_gluten->allergen_id))->create();
        }
    }

    $milk_ingredients = [
        'brie',
        'butter_unsalted',
        'butter_salted',
        'buttermilk',
        'camembert',
        'cheddar_cheese',
        'condensed_milk',
        'cottage_cheese',
        'cream_cheese',
        'creme_fraiche',
        'double_cream',
        'evaporated_milk',
        'feta_cheese',
        'ghee',
        'goats_cheese',
        'gorgonzola',
        'greek_yogurt',
        'gruyere_cheese',
        'halloumi',
        'heavy_cream',
        'manchego',
        'mascarpone',
        'milk_skimmed',
        'mozzarella_ball',
        'mozzarella_shredded',
        'paneer',
        'parmesan_reggiano',
        'pecorino_romano',
        'pesto_green',
        'pesto_red',
        'quarg_cheese',
        'ricotta_cheese',
        'sour_cream',
        'stilton_blue',
        'whole_milk'
    ];
    foreach ($milk_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_milk->allergen_id))->create();
        }
    }

    $egg_ingredients = [
        'finger_biscuits',
        'large_eggs',
        'mayonaisse',
        'meringue_nests',
        'salad_cream',
        'wonton_wrappers'
    ];
    foreach ($egg_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_eggs->allergen_id))->create();
        }
    }

    $fish_ingredients = [
        'anchovy_fillets',
        'cod_fillet',
        'fish_sauce',
        'haddock_fillet',
        'mackerel_fillets',
        'salmon_fillet',
        'salmon_smoked',
        'sardines_canned',
        'tuna_steak',
        'white_fish_fillet',
        'worcestershire_sauce'
    ];
    foreach ($fish_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_fish->allergen_id))->create();
        }
    }

    $crustacean_ingredients = [
        'cooked_prawns',
        'crab_meat_canned',
        'king_prawns',
        'prawns_tiger',
        'raw_prawns'
    ];
    foreach ($crustacean_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_crustaceans->allergen_id))->create();
        }
    }

    $mollusc_ingredients = [
        'clams_fresh',
        'mussels_fresh',
        'oyster_sauce',
        'oysters_fresh',
    ];
    foreach ($mollusc_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_molluscs->allergen_id))->create();
        }
    }

    $nut_ingredients = [
        'almond_extract',
        'almond_flour',
        'almond_milk',
        'brazil_nuts',
        'cashew_nuts',
        'ground_almonds',
        'hazelnuts',
        'marzipan',
        'pecans',
        'pistachios',
        'walnuts'
    ];
    foreach ($nut_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_nuts->allergen_id))->create();
        }
    }

    $peanut_ingredients = [
        'peanut_butter',
        'peanuts_roasted'
    ];
    foreach ($peanut_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_peanuts->allergen_id))->create();
        }
    }

    $soya_ingredients = [
        'edamame_beans',
        'hoisin_sauce',
        'light_soy_sauce',
        'miso_paste_red',
        'miso_paste_white',
        'soy_milk',
        'soy_sauce',
        'tofu_firm',
        'tofu_silken'
    ];
    foreach ($soya_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_soya->allergen_id))->create();
        }
    }

    $mustard_ingredients = [
        'dijon_mustard',
        'english_mustard',
        'french_mustard',
        'mayonaisse',
        'mustard_grain',
        'mustard_seeds',
        'piccalilli_pickle',
        'salad_cream'
    ];
    foreach ($mustard_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_mustard->allergen_id))->create();
        }
    }

    $sesame_ingredients = [
        'oil_sesame_toasted',
        'sesame_seeds_black',
        'sesame_seeds_white',
        'tahini'
    ];
    foreach ($sesame_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_sesame->allergen_id))->create();
        }
    }

    $celery_ingredients = [
        'beef_stock',
        'bouillon_powder',
        'celery',
        'celery_salt',
        'celery_seed',
        'chicken_stock',
        'vegetable_stock'
    ];
    foreach ($celery_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_celery->allergen_id))->create();
        }
    }

    $sulphite_ingredients = [
        'apple_cider_vinegar',
        'balsamic_vinegar',
        'cider',
        'dried_apricots',
        'malt_vinegar',
        'red_wine',
        'red_wine_vinegar',
        'rice_vinegar',
        'rice_wine_shaoxing',
        'sherry_dry',
        'white_wine',
        'white_wine_vinegar'
    ];
    foreach ($sulphite_ingredients as $ing) {
        if (isset($ing_db[$ing])) {
            (new Allergy($ing_db[$ing]->ingredient_id, $alg_sulphites->allergen_id))->create();
        }
    }

    #endreigon allergies

    file_put_contents($file_path_json, json_encode($ing_db));
} else {
    $ing_db = json_decode(file_get_contents($file_path_json), true);

    foreach ($ing_db as $ing_key => $ing_json) {
        $ing_db[$ing_key] = new Ingredient(...$ing_json);
    }
}


