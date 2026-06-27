<?php

require_once __DIR__ . '/../init.php';

require_once __DIR__ . '/units.php';
require_once __DIR__ . '/ingredients.php';

#region recipes
$recipes_assoc = [
    [
        'id' => 1,
        'name' => 'Toad in the hole',
        'description' => 'Classic British sausages in Yorkshire pudding batter. A family favourite that is surprisingly easy to make and perfect for a cold winter evening.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Preheat the oven to 200°C (180°C fan).',
            ],
            [
                'step' => 'Sift the flour and a pinch of salt into a large mixing bowl.',
                'ingredients' => [
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 110,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Make a well in the centre of the flour and crack in the eggs.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Whisk the eggs, gradually drawing in the flour from the sides.',
            ],
            [
                'step' => 'Slowly pour in the milk, whisking continuously to form a smooth batter.',
                'ingredients' => [
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the fennel seeds and ground black pepper.',
                'ingredients' => [
                    [
                        'id' => $ing_db['fennel_seed'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Cover the bowl and leave the batter to rest for at least 30 minutes (or up to 3 hours).',
            ],
            [
                'step' => 'Place the sausages in a roasting tin, drizzle with a little oil, and bake for 15 minutes until browned.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pork_sausages'],
                        'amount' => 8,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 5,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Remove the tin from the oven and carefully pour the resting batter over the hot sausages.',
            ],
            [
                'step' => 'Return to the oven and bake for 25-30 minutes until the batter is risen, crisp, and golden brown.',
            ],
        ],
        'tags' => ['dinner', 'british', 'simple', 'one pot meal', 'winter'],
    ],
    [
        'id' => 2,
        'name' => 'Turkey with peaches',
        'description' => 'A sweet and savoury dish featuring tender turkey and juicy peaches in a creamy nutmeg-scented sauce.',
        'timeMinutes' => 30,
        'servings' => 3,
        'steps' => [
            [
                'step' => 'Slice the turkey breast into bite-sized pieces.',
                'ingredients' => [
                    [
                        'id' => $ing_db['turkey_breast'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'In a bowl, mix the flour, ground nutmeg, salt, and pepper.',
                'ingredients' => [
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['ground_nutmeg'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Toss the turkey pieces in the seasoned flour until evenly coated.',
            ],
            [
                'step' => 'Heat the vegetable oil in a large frying pan over medium-high heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry the turkey pieces until golden brown all over, then remove from the pan and set aside.',
            ],
            [
                'step' => 'Finely chop the white onion and crush the garlic cloves.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'In the same pan, fry the onion until softened, then add the garlic and cook for 1 minute.',
            ],
            [
                'step' => 'Stir in any remaining seasoned flour and cook for 1 minute.',
            ],
            [
                'step' => 'Gradually pour in the chicken stock, stirring continuously to prevent lumps.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Drain the tinned peaches and cut them into slices.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tinned_peaches'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Stir the crème fraîche and sliced peaches into the sauce.',
                'ingredients' => [
                    [
                        'id' => $ing_db['creme_fraiche'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Return the turkey to the pan and simmer gently for 5-10 minutes until the turkey is cooked through and the sauce has thickened.',
            ],
        ],
        'tags' => ['dinner', 'sweet & savoury', 'turkey'],
    ],
    [
        'id' => 3,
        'name' => 'Chili con carne',
        'description' => 'A hearty beef chili with a complex spice profile. Best served with rice, sour cream, and fresh coriander.',
        'timeMinutes' => 80,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Finely chop the white onion, celery, and red bell pepper.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['celery'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['red_bell_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Heat a little oil in a large heavy-based pot over medium heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry the onion, celery, and red pepper until softened (about 8-10 minutes).',
            ],
            [
                'step' => 'Crush the garlic and add it to the pot, cooking for another minute.',
                'ingredients' => [
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the chilli powder, cumin, and smoked paprika, and cook for 1 minute until fragrant.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chilli_powder'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cumin'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Add the minced beef, breaking it up with a spoon, and cook until browned all over.',
                'ingredients' => [
                    [
                        'id' => $ing_db['minced_beef'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the tomato purée and cook for 2 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_puree'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Pour in the beef stock and chopped tomatoes, then add the dried oregano and sugar.',
                'ingredients' => [
                    [
                        'id' => $ing_db['beef_stock'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['chopped_tomatoes'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['caster_sugar'],
                        'amount' => 15,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Bring to a boil, then reduce the heat, cover, and simmer gently for 45 minutes, stirring occasionally.',
            ],
            [
                'step' => 'Drain and rinse the red kidney beans, then stir them into the chili.',
                'ingredients' => [
                    [
                        'id' => $ing_db['red_kidney_beans'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Simmer uncovered for a further 15 minutes to allow the sauce to thicken.',
            ],
        ],
        'tags' => ['dinner', 'comforting', 'mexican'],
    ],
    [
        'id' => 4,
        'name' => 'Butter chicken',
        'description' => 'Rich, creamy Indian classic with aromatic spices and a smooth tomato-based sauce.',
        'timeMinutes' => 60,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Cut the chicken thighs into bite-sized pieces.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'In a bowl, mix the chicken with the lemon juice, Greek yogurt, half of the garlic (crushed), half of the ginger (grated), and a pinch of salt. Leave to marinate for at least 30 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 25,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['fresh_ginger'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Heat the sunflower oil in a large pan over high heat and fry the marinated chicken until charred and cooked through. Remove and set aside.',
                'ingredients' => [
                    [
                        'id' => $ing_db['sunflower_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'In the same pan, melt the butter over medium heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Lightly crush the cardamom pods and add them to the butter along with the remaining crushed garlic and grated ginger. Fry for 1 minute.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cardamom_pods'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the garam masala, cumin, coriander, and smoked paprika, cooking for 30 seconds until fragrant.',
                'ingredients' => [
                    [
                        'id' => $ing_db['garam_masala'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cumin'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_coriander'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Pour in the tomato passata and bring to a gentle simmer.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 400,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Simmer the sauce for 15-20 minutes until slightly thickened.',
            ],
            [
                'step' => 'Stir in the double cream and return the cooked chicken to the pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Simmer for a further 5 minutes until everything is heated through.',
            ],
        ],
        'tags' => ['indian', 'curry', 'dinner', 'classic'],
    ],
    [
        'id' => 5,
        'name' => 'Sausage leek gnocchi',
        'description' => 'Quick creamy one-pot gnocchi with savoury sausages and sweet leeks.',
        'timeMinutes' => 50,
        'servings' => 3,
        'steps' => [
            [
                'step' => 'Slice the leeks, finely chop the onion, crush the garlic, and roughly chop the tomatoes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['leeks'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['tomato'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Squeeze the sausage meat out of its casings.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pork_sausages'],
                        'amount' => 8,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Heat a little olive oil in a large deep frying pan or casserole dish over medium-high heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add the sausage meat, breaking it up with a spoon, and fry until browned and crispy.',
            ],
            [
                'step' => 'Reduce the heat to medium and add the leeks and onion to the pan with the sausage meat.',
            ],
            [
                'step' => 'Sweat the vegetables for 5-8 minutes until softened, then add the garlic and cook for 1 minute.',
            ],
            [
                'step' => 'Pour in the vegetable stock and bring to a gentle simmer.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_stock'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Add the gnocchi to the pan and simmer for 2-3 minutes, or until they float to the surface.',
                'ingredients' => [
                    [
                        'id' => $ing_db['gnocchi'],
                        'amount' => 400,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the crème fraîche, chopped tomatoes, and grated parmesan cheese.',
                'ingredients' => [
                    [
                        'id' => $ing_db['creme_fraiche'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['parmesan_cheese'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Season with sea salt and ground black pepper to taste, and simmer for another 2 minutes until the sauce coats the gnocchi.',
                'ingredients' => [
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
        ],
        'tags' => ['italian', 'pasta', 'one pot dish', 'dinner'],
    ],
    [
        'id' => 6,
        'name' => 'Chicken gyros',
        'description' => 'Greek street food at home with marinated chicken, tzatziki, and warm pita bread.',
        'timeMinutes' => 90,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'For the marinade: Mix half the Greek yogurt, 3 crushed garlic cloves, 4 tbsp olive oil, 3 tbsp lemon juice, and all the spices in a large bowl.',
                'ingredients' => [
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 4,
                        'unit' => Units::$units_db['tbsp']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 3,
                        'unit' => Units::$units_db['tbsp']
                    ],
                    [
                        'id' => $ing_db['ground_coriander'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cinnamon'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['cayenne_pepper'],
                        'amount' => 0.25,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Cut the chicken thighs into chunks, coat thoroughly in the marinade, cover, and chill for at least 1 hour.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 8,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Preheat the oven to 200°C (180°C fan).',
            ],
            [
                'step' => 'Thread the marinated chicken pieces onto skewers and place them on a baking tray lined with foil.',
            ],
            [
                'step' => 'Roast the chicken skewers in the oven for 25-30 minutes, turning halfway, until cooked through and slightly charred.',
            ],
            [
                'step' => 'Cook the frozen chips according to the packet instructions.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chips'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'To make the tzatziki: Grate the cucumber and squeeze out the excess water. Mix with the remaining Greek yogurt, 3 crushed garlic cloves, 3 tbsp lemon juice, chopped mint, and a pinch of salt.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cucumber'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 3,
                        'unit' => Units::$units_db['tbsp']
                    ],
                    [
                        'id' => $ing_db['fresh_mint'],
                        'amount' => 2,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Finely slice the red onion and tomatoes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['red_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['tomato'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Warm the pita breads in the oven or a toaster.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pita_bread'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'To assemble: Spread tzatziki on a warm pita, add pieces of roasted chicken, chips, sliced red onion, and tomato. Squeeze over some fresh lemon juice before wrapping.',
                'ingredients' => [
                    [
                        'id' => $ing_db['whole_lemon'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
        ],
        'tags' => ['dinner', 'greek', 'mediterranean', 'national dish'],
    ],
    [
        'id' => 7,
        'name' => 'Pasta bacon broccoli',
        'description' => 'Quick creamy pasta with crispy bacon and fresh broccoli.',
        'timeMinutes' => 30,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Bring a large pan of salted water to the boil and cook the penne according to the packet instructions.',
                'ingredients' => [
                    [
                        'id' => $ing_db['penne'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Chop the broccoli into small florets.',
                'ingredients' => [
                    [
                        'id' => $ing_db['floret_broccoli'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add the broccoli to the pasta water for the final 3-4 minutes of cooking time.',
            ],
            [
                'step' => 'Meanwhile, chop the bacon rashers and finely dice the white onion.',
                'ingredients' => [
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Heat a large frying pan over medium-high heat and fry the bacon until crispy.',
            ],
            [
                'step' => 'Add the diced onion to the bacon and fry for a further 5 minutes until softened.',
            ],
            [
                'step' => 'Drain the pasta and broccoli, reserving a splash of the cooking water.',
            ],
            [
                'step' => 'Add the pasta, broccoli, crème fraîche, and a splash of the pasta water to the frying pan with the bacon and onion.',
                'ingredients' => [
                    [
                        'id' => $ing_db['creme_fraiche'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir everything together over a low heat until the sauce is creamy and coats the pasta.',
            ],
            [
                'step' => 'Season generously with black pepper and a little sea salt before serving.',
                'ingredients' => [
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
        ],
        'tags' => ['dinner', 'italian', 'pasta'],
    ],
    [
        'id' => 8,
        'name' => 'Seafood and chicken paella',
        'description' => 'Vibrant Spanish rice dish with saffron, seafood, and chicken.',
        'timeMinutes' => 45,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Place the saffron strands in a small bowl with 2 tablespoons of warm water and leave to infuse.',
                'ingredients' => [
                    [
                        'id' => $ing_db['saffron'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Chop the chicken thighs into chunks, slice the chorizo, finely chop the onion, dice the red pepper, and crush the garlic.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['chorizo_sausage'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['red_bell_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Heat the olive oil in a large, wide paella pan or frying pan over medium-high heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry the chicken and chorizo for 5-8 minutes until the chicken is browned and the chorizo has released its oils.',
            ],
            [
                'step' => 'Add the onion, red pepper, and garlic to the pan and sauté for 5 minutes until softened.',
            ],
            [
                'step' => 'Stir in the paella rice, ensuring all the grains are coated in the flavorful oils.',
                'ingredients' => [
                    [
                        'id' => $ing_db['paella_rice'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Pour in the chicken stock and the infused saffron water. Season with a little salt.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 700,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Bring to a simmer, then reduce the heat to low. Do not stir the rice from this point onwards.',
            ],
            [
                'step' => 'Cook uncovered for 15 minutes, or until most of the liquid has been absorbed and the rice is almost tender.',
            ],
            [
                'step' => 'Scatter the raw prawns and frozen peas over the top of the rice and push them down slightly into the mixture.',
                'ingredients' => [
                    [
                        'id' => $ing_db['raw_prawns'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['frozen_peas'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Cook for a further 5-8 minutes until the prawns are pink and cooked through, and all the liquid has been absorbed.',
            ],
            [
                'step' => 'Remove from the heat, cover with a clean tea towel, and let it rest for 5 minutes before serving.',
            ],
        ],
        'tags' => ['spanish', 'seafood', 'chicken', 'dinner'],
    ],
    [
        'id' => 9,
        'name' => 'Pork and apple burgers',
        'description' => 'Juicy burgers with a sweet twist of grated apple.',
        'timeMinutes' => 15,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Peel and coarsely grate the apple. Finely dice the half white onion.',
                'ingredients' => [
                    [
                        'id' => $ing_db['desert_apple'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'In a large bowl, combine the pork mince, grated apple, diced onion, breadcrumbs, and egg.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pork_mince'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['breadcrumbs'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Season well with sea salt and ground black pepper.',
                'ingredients' => [
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Use your hands to mix everything thoroughly, then divide the mixture into 4 equal portions.',
            ],
            [
                'step' => 'Shape each portion into a flat burger patty.',
            ],
            [
                'step' => 'Heat the vegetable oil in a large frying pan over medium heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry the burgers for 5-6 minutes on each side, or until thoroughly cooked through and golden brown.',
            ],
            [
                'step' => 'Slice the burger buns in half and lightly toast them if desired.',
                'ingredients' => [
                    [
                        'id' => $ing_db['burger_buns'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Serve the pork and apple burgers in the buns with your favourite accompaniments.',
            ],
        ],
        'tags' => ['burger', 'pork', 'simple', 'dinner'],
    ],
    [
        'id' => 10,
        'name' => 'Veggie lasagne',
        'description' => 'Comforting meat-free lasagne with layers of roasted vegetables and béchamel sauce.',
        'timeMinutes' => 45,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Preheat the oven to 200°C (180°C fan).',
            ],
            [
                'step' => 'Dice the aubergine and courgettes into roughly 2cm cubes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['aubergine'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['courgette'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Spread the vegetables on a baking tray, drizzle with olive oil, season, and roast for 20-25 minutes until soft and slightly charred.',
                'ingredients' => [
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Meanwhile, to make the white sauce, melt the butter in a saucepan over medium heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 30,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the flour and cook for 1-2 minutes to form a paste (roux).',
                'ingredients' => [
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 25,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Gradually whisk in the whole milk, stirring constantly until the sauce thickens and is completely smooth.',
                'ingredients' => [
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 1,
                        'unit' => Units::$units_db['l']
                    ],
                ]
            ],
            [
                'step' => 'Remove the sauce from the heat and stir in half of the grated cheddar cheese.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 125,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'In a separate pan, briefly wilt the fresh spinach.',
                'ingredients' => [
                    [
                        'id' => $ing_db['spinach'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'To assemble the lasagne, spread a thin layer of tomato passata in the base of a baking dish.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 250,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Add a layer of lasagne sheets, followed by half of the roasted vegetables, half of the wilted spinach, and more passata.',
                'ingredients' => [
                    [
                        'id' => $ing_db['lasagne_sheets'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 250,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Repeat the layers (lasagne sheets, remaining veg, remaining spinach, passata).',
                'ingredients' => [
                    [
                        'id' => $ing_db['lasagne_sheets'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Top with a final layer of lasagne sheets and pour over the cheese sauce to cover completely.',
            ],
            [
                'step' => 'Sprinkle the remaining grated cheddar cheese over the top.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 125,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Bake for 30-35 minutes until the top is bubbling and golden brown.',
            ],
        ],
        'tags' => ['vegetarian', 'italian', 'pasta', 'dinner'],
    ],
    [
        'id' => 11,
        'name' => 'Katsu chicken',
        'description' => 'Crispy breaded chicken with a mildly spiced Japanese curry sauce.',
        'timeMinutes' => 20,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Place the chicken breasts between two sheets of cling film and bash them gently with a rolling pin until they are about 1cm thick.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_breast'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Set up a breading station: seasoned flour on one plate, a beaten egg in a shallow bowl, and breadcrumbs on another plate.',
                'ingredients' => [
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['breadcrumbs'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Coat each chicken breast first in the flour, then dip into the egg, and finally coat thoroughly in the breadcrumbs.',
            ],
            [
                'step' => 'Heat 2 tbsp of vegetable oil in a large frying pan over medium-high heat.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry the breaded chicken for 5-6 minutes on each side until golden, crispy, and cooked through. Remove and keep warm.',
            ],
            [
                'step' => 'To make the sauce: Finely chop the onions and carrots, crush the garlic, and grate the ginger.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['fresh_ginger'],
                        'amount' => 10,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'In a separate saucepan, heat the remaining 1 tbsp of oil and fry the onion and carrots until softened.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the garlic and ginger, cooking for 1 minute.',
            ],
            [
                'step' => 'Add the mild curry powder and stir well to coat the vegetables.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mild_curry_powder'],
                        'amount' => 3,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Pour in the chicken stock and soy sauce. Bring to a boil, then reduce the heat and simmer for 15 minutes until the carrots are tender.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['soy_sauce'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Use a stick blender to blend the sauce until smooth (or leave chunky if preferred).',
            ],
            [
                'step' => 'Slice the crispy chicken and serve with rice, pouring the warm katsu curry sauce over the top.',
                'ingredients' => [
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
        ],
        'tags' => ['japanese', 'chicken', 'curry', 'dinner'],
    ],
    [
        'id' => 12,
        'name' => 'Tomato mozzarella toastie',
        'description' => 'Classic cheesy toastie with basil pesto and fresh tomato.',
        'timeMinutes' => 10,
        'servings' => 1,
        'steps' => [
            [
                'step' => 'Butter one side of each slice of bread.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_bread'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 10,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Slice the tomato and the mozzarella ball.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['mozzarella_ball'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Place one slice of bread, butter-side down, on a board or directly into a cold frying pan.',
            ],
            [
                'step' => 'Spread the basil pesto over the unbuttered side facing up.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pesto'],
                        'amount' => 4,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Layer the sliced mozzarella and tomato evenly over the pesto.',
            ],
            [
                'step' => 'Season the tomatoes with a little sea salt and ground black pepper.',
                'ingredients' => [
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_black_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Top with the second slice of bread, ensuring the buttered side is facing outwards.',
            ],
            [
                'step' => 'Place the frying pan over medium heat and toast the sandwich for 3-4 minutes until the bottom is golden brown and crispy.',
            ],
            [
                'step' => 'Carefully flip the toastie using a spatula and cook for a further 3-4 minutes on the other side, pressing down gently until the cheese is melted.',
            ],
            [
                'step' => 'Cut in half and serve immediately.',
            ],
        ],
        'tags' => ['lunch', 'snack', 'vegetarian'],
    ],
    [
        'id' => 13,
        'name' => 'Brie + cranberry + spinach + bacon jacket potatoes',
        'description' => 'Gourmet stuffed potatoes with melted brie and sweet cranberry.',
        'timeMinutes' => 60,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Preheat the oven to 200°C (180°C fan).',
            ],
            [
                'step' => 'Prick the large potatoes several times with a fork, rub them lightly with a little olive oil, and sprinkle with sea salt.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['sea_salt'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Bake the potatoes directly on the oven shelf for 1 to 1.5 hours, until the skin is crisp and the inside is soft.',
            ],
            [
                'step' => 'While the potatoes are baking, slice the brie and roughly chop the bacon rashers.',
                'ingredients' => [
                    [
                        'id' => $ing_db['brie'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Fry the bacon in a pan until crispy, then remove from the heat.',
            ],
            [
                'step' => 'In the same pan using the residual bacon fat, briefly wilt the fresh spinach.',
                'ingredients' => [
                    [
                        'id' => $ing_db['spinach'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Once the potatoes are cooked, remove them from the oven and cut a cross in the top of each one, squeezing the base slightly to open them up.',
            ],
            [
                'step' => 'Dollop a spoonful of cranberry sauce into each potato.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cranberry_sauce'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Layer in the wilted spinach, crispy bacon, and top generously with slices of brie.',
            ],
            [
                'step' => 'Return the filled potatoes to the oven for 5 minutes, or until the brie is oozing and melted.',
            ],
        ],
        'tags' => ['dinner', 'lunch', 'potato'],
    ],
    [
        'id' => 14,
        'name' => 'Bolognese',
        'description' => 'A slow-cooked, rich Italian meat sauce perfect with tagliatelle or spaghetti.',
        'timeMinutes' => 120,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Finely dice the onion, carrot, and celery.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['celery'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Sauté the vegetables in olive oil over medium heat until softened.',
                'ingredients' => [
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add the minced beef and brown thoroughly, breaking up lumps.',
                'ingredients' => [
                    [
                        'id' => $ing_db['minced_beef'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the garlic and tomato purée, cooking for 2 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['tomato_puree'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add chopped tomatoes, beef stock, and oregano.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chopped_tomatoes'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['beef_stock'],
                        'amount' => 200,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Simmer on low heat for at least 1.5 hours until thick and rich.',
            ],
        ],
        'tags' => ['italian', 'dinner', 'classic'],
    ],
    [
        'id' => 15,
        'name' => 'Lasagne',
        'description' => 'Layers of rich bolognese, creamy béchamel sauce, and pasta topped with melted cheese.',
        'timeMinutes' => 90,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Prepare a meat sauce by browning beef with onions and simmering with tomatoes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['minced_beef'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['chopped_tomatoes'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['red_wine'],
                        'amount' => 200,
                        'unit' => Units::$units_db['ml']
                    ]
                ]
            ],
            [
                'step' => 'Make a béchamel by melting butter, stirring in flour, and gradually whisking in milk until thick.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 600,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'In an ovenproof dish, layer meat sauce, then pasta sheets, then white sauce.',
                'ingredients' => [
                    [
                        'id' => $ing_db['lasagne_sheets'],
                        'amount' => 12,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Repeat layers, finishing with white sauce on top.',
            ],
            [
                'step' => 'Sprinkle with cheddar and parmesan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['parmesan_cheese'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Bake at 200°C for 35-40 minutes until golden and bubbling.',
            ],
        ],
        'tags' => ['italian', 'dinner', 'baked'],
    ],
    [
        'id' => 16,
        'name' => 'Veggie Lasagne',
        'description' => 'A Mediterranean vegetable twist on the classic baked pasta.',
        'timeMinutes' => 75,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Slice and roast the aubergine, courgette, and peppers until tender.',
                'ingredients' => [
                    [
                        'id' => $ing_db['aubergine'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['courgette'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['red_bell_pepper'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Combine the roasted vegetables with passata and herbs.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Make a white sauce using the butter, flour, and milk.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 40,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 40,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Layer vegetable sauce, pasta, and white sauce in a dish.',
                'ingredients' => [
                    [
                        'id' => $ing_db['lasagne_sheets'],
                        'amount' => 9,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Top with torn mozzarella and bake at 190°C for 30 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mozzarella_ball'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
        ],
        'tags' => ['vegetarian', 'italian', 'dinner'],
    ],
    [
        'id' => 17,
        'name' => 'Gyros',
        'description' => 'Greek-style wraps with spiced meat, fresh salad, and creamy yogurt sauce.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Marinate chicken in oil, oregano, paprika, and garlic, then grill until charred.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Grate cucumber and squeeze out liquid, mix with yogurt and garlic for tzatziki.',
                'ingredients' => [
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['cucumber'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Warm the pita breads.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pita_bread'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Slice the chicken and place in pitas with sliced tomatoes, onion, and tzatziki.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['red_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Wrap tightly and serve immediately.',
            ],
        ],
        'tags' => ['greek', 'street-food', 'quick'],
    ],
    [
        'id' => 18,
        'name' => 'Chicken Tikka Masala',
        'description' => "The nation's favourite curry: marinated chicken in a creamy, spiced tomato sauce.",
        'timeMinutes' => 50,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Coat diced chicken in yogurt and half the spices; grill until slightly charred.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_breast'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['garam_masala'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cumin'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['turmeric'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Fry onions, ginger, and garlic in a pan until soft.',
                'ingredients' => [
                    [
                        'id' => $ing_db['fresh_ginger'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add remaining spices and passata, simmer for 15 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 400,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['garam_masala'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cumin'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['turmeric'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the grilled chicken and double cream.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Heat through and serve with basmati rice.',
            ],
        ],
        'tags' => ['curry', 'indian', 'dinner'],
    ],
    [
        'id' => 19,
        'name' => 'Meatballs (Pork)',
        'description' => 'Juicy pork meatballs seasoned with fennel and herbs in a light tomato sauce.',
        'timeMinutes' => 45,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Mix pork mince, breadcrumbs, egg, crushed fennel seeds, and garlic.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pork_mince'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['breadcrumbs'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['fennel_seed'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Roll into golf-ball sized spheres.',
            ],
            [
                'step' => 'Brown the meatballs in a pan with a little oil.',
            ],
            [
                'step' => 'Pour over the passata and oregano, then simmer for 20 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Serve over pasta with a grating of parmesan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['parmesan_cheese'],
                        'amount' => 30,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
        ],
        'tags' => ['pork', 'dinner', 'family'],
    ],
    [
        'id' => 20,
        'name' => 'Normandy Pork',
        'description' => 'A classic French dish of pork cooked with apples, cider, and cream.',
        'timeMinutes' => 60,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Slice pork into medallions and brown in butter; remove from pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['pork_loin'],
                        'amount' => 600,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 25,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Sauté sliced onions and apples until golden.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['desert_apple'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Pour in cider and stock, return pork to the pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cider'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 150,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Simmer for 20 minutes until the pork is tender.',
            ],
            [
                'step' => 'Stir in the cream and heat gently before serving.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['dried_oregano'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
        ],
        'tags' => ['french', 'pork', 'creamy'],
    ],
    [
        'id' => 21,
        'name' => 'Creamy Chicken Curry',
        'description' => 'A mild and silky curry using coconut milk or cream, perfect for the whole family.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Fry onion and diced chicken until chicken is browned.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 5,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Stir in curry powder and cook for 1 minute.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mild_curry_powder'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add chicken stock and simmer for 15 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 200,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Add peas and double cream, simmering for another 5 minutes until thickened.',
                'ingredients' => [
                    [
                        'id' => $ing_db['frozen_peas'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 150,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Serve with naan bread or rice.',
            ],
        ],
        'tags' => ['curry', 'chicken', 'mild'],
    ],
    [
        'id' => 22,
        'name' => 'Eggs Benedict',
        'description' => 'The ultimate brunch: poached eggs and ham on muffins with buttery hollandaise.',
        'timeMinutes' => 20,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Make hollandaise by whisking 2 egg yolks and lemon juice over a bain-marie, slowly adding melted butter.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 10,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Toast the bread (or muffins) and fry the bacon until crispy.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_bread'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Poach the remaining eggs in simmering water for 3 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Place bacon on toast, top with poached eggs, and smother in hollandaise.',
            ],
        ],
        'tags' => ['brunch', 'breakfast', 'eggs'],
    ],
    [
        'id' => 23,
        'name' => 'Salad Niçoise',
        'description' => 'A fresh French salad with tuna, green beans, and hard-boiled eggs.',
        'timeMinutes' => 30,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Boil potatoes until tender; blanch green beans in the same water.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['green_beans'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Hard-boil the eggs, then peel and quarter.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Sear tuna steaks in a hot pan for 2 minutes each side.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tuna_steak'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Arrange lettuce, potatoes, beans, tomatoes, olives, and eggs on a plate.',
                'ingredients' => [
                    [
                        'id' => $ing_db['black_olives'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['tomato'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Top with sliced tuna and a dressing of olive oil and lemon.',
                'ingredients' => [
                    [
                        'id' => $ing_db['olive_oil'],
                        'amount' => 3,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
        ],
        'tags' => ['salad', 'french', 'healthy'],
    ],
    [
        'id' => 24,
        'name' => 'Carrot and Coriander Soup',
        'description' => 'A vibrant and healthy soup with earthy spices and fresh herbs.',
        'timeMinutes' => 35,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Sauté diced onion and carrots in a large pot.',
                'ingredients' => [
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['vegetable_oil'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add ground coriander and cook for 1 minute.',
                'ingredients' => [
                    [
                        'id' => $ing_db['ground_coriander'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Pour in the stock and simmer for 20 minutes until carrots are soft.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_stock'],
                        'amount' => 1000,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Blend until smooth using a stick blender.',
            ],
            [
                'step' => 'Season well and serve with crusty bread.',
            ],
        ],
        'tags' => ['soup', 'vegetarian', 'lunch'],
    ],
    [
        'id' => 25,
        'name' => 'Leek and Potato Soup',
        'description' => 'A thick, comforting British classic.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Clean and slice the leeks; peel and dice the potatoes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['leeks'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Melt butter and sweat the leeks and onions until soft but not brown.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 30,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Add potatoes and stock; simmer for 20 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['vegetable_stock'],
                        'amount' => 800,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Blend half the soup for a chunky-creamy texture.',
            ],
            [
                'step' => 'Stir in the cream and season.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 50,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
        ],
        'tags' => ['soup', 'classic', 'british'],
    ],
    [
        'id' => 26,
        'name' => 'Cabbage and Bacon Soup',
        'description' => 'A rustic, hearty soup that makes the most of simple ingredients.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Fry chopped bacon until crisp; remove half for garnish.',
                'ingredients' => [
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add onion and diced potato to the pan, cooking for 5 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add shredded cabbage and stock.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 1000,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Simmer for 15 minutes until vegetables are tender.',
            ],
            [
                'step' => 'Serve topped with the reserved crispy bacon.',
            ],
        ],
        'tags' => ['soup', 'rustic', 'bacon'],
    ],
    [
        'id' => 27,
        'name' => 'Broccoli and Stilton Soup',
        'description' => 'Indulgently creamy with a punchy hit of blue cheese.',
        'timeMinutes' => 30,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Sauté onion until soft.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add chopped broccoli and stock; simmer for 10-12 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['floret_broccoli'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['vegetable_stock'],
                        'amount' => 800,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Blend until smooth.',
            ],
            [
                'step' => 'Stir in the crumbled Stilton and cream until melted.',
                'ingredients' => [
                    [
                        'id' => $ing_db['stilton_cheese'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 50,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Season with plenty of black pepper.',
            ],
        ],
        'tags' => ['soup', 'cheese', 'vegetarian'],
    ],
    [
        'id' => 28,
        'name' => 'Hunters Chicken',
        'description' => 'Chicken breast wrapped in bacon, smothered in BBQ sauce and melted cheese.',
        'timeMinutes' => 35,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Wrap each chicken breast in two rashers of bacon.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_breast'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Bake in the oven at 200°C for 20 minutes.',
            ],
            [
                'step' => 'Pour BBQ sauce over the chicken and top with cheese.',
                'ingredients' => [
                    [
                        'id' => $ing_db['bbq_sauce'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Bake for another 5-10 minutes until cheese is golden and bubbling.',
            ],
        ],
        'tags' => ['chicken', 'pub-classic', 'dinner'],
    ],
    [
        'id' => 29,
        'name' => 'Country Chicken Pie',
        'description' => 'Tender chicken and veg in a creamy sauce under a flaky puff pastry lid.',
        'timeMinutes' => 60,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Fry chicken, leeks, and carrots until softened.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['leeks'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add stock and cream; simmer until the sauce thickens slightly.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Pour into a pie dish.',
            ],
            [
                'step' => 'Top with puff pastry, brush with beaten egg, and cut a steam vent.',
                'ingredients' => [
                    [
                        'id' => $ing_db['puff_pastry'],
                        'amount' => 320,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Bake at 200°C for 25 minutes until puffed and golden.',
            ],
        ],
        'tags' => ['pie', 'comforting', 'british'],
    ],
    [
        'id' => 30,
        'name' => 'Mac & Cheese',
        'description' => 'The ultimate cheesy pasta bake with a crispy topping.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Boil pasta for 2 minutes less than the pack instructions.',
                'ingredients' => [
                    [
                        'id' => $ing_db['penne'],
                        'amount' => 400,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Make a cheese sauce by making a roux with butter/flour, adding milk, then cheese.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 600,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Mix the pasta into the cheese sauce.',
            ],
            [
                'step' => 'Transfer to a dish, top with breadcrumbs and extra cheese.',
                'ingredients' => [
                    [
                        'id' => $ing_db['breadcrumbs'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Bake at 200°C for 20 minutes.',
            ],
        ],
        'tags' => ['pasta', 'cheese', 'kids'],
    ],
    [
        'id' => 31,
        'name' => 'Potato Salad',
        'description' => 'Creamy new potatoes with spring onions and a tangy mayo dressing.',
        'timeMinutes' => 25,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Boil cubed potatoes in salted water until tender.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 7,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Drain and let cool completely.',
            ],
            [
                'step' => 'Mix mayonnaise, mustard, and lemon juice.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mayonaisse'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['dijon_mustard'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Toss potatoes with the dressing and sliced spring onions.',
                'ingredients' => [
                    [
                        'id' => $ing_db['spring_onion'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
        ],
        'tags' => ['side', 'salad', 'bbq'],
    ],
    [
        'id' => 32,
        'name' => 'Creamy Cheesy Dauphinoise Potatoes',
        'description' => 'Thinly sliced potatoes baked in a garlic-infused cream sauce.',
        'timeMinutes' => 75,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Thinly slice potatoes (approx 2mm thick).',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 7,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Heat cream, milk, and crushed garlic in a pan until just simmering.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 400,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 100,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Layer potatoes in a buttered dish, seasoning each layer.',
            ],
            [
                'step' => 'Pour over the cream mixture.',
            ],
            [
                'step' => 'Top with cheese and bake at 160°C for 1 hour.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cheddar_cheese'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
        ],
        'tags' => ['side', 'french', 'indulgent'],
    ],
    [
        'id' => 33,
        'name' => 'Coleslaw',
        'description' => 'Crunchy, fresh, and much better than shop-bought.',
        'timeMinutes' => 15,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Finely shred the cabbage and onion.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Grate the carrots.',
                'ingredients' => [
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Whisk mayonnaise and lemon juice together.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mayonaisse'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Toss everything together until well coated.',
            ],
        ],
        'tags' => ['side', 'salad', 'fresh'],
    ],
    [
        'id' => 34,
        'name' => 'French Onion Soup',
        'description' => 'Deeply caramelised onions in a rich beef broth, topped with cheesy bread.',
        'timeMinutes' => 60,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Slowly cook sliced onions in butter for 40 minutes until dark brown.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Add brandy and deglaze the pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['brandy'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add stock and simmer for 15 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['beef_stock'],
                        'amount' => 1200,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Toast bread, top with cheese, and grill until melted.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_bread'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['gruyere_cheese'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Serve soup in bowls with the cheesy toast floating on top.',
            ],
        ],
        'tags' => ['french', 'soup', 'classic'],
    ],
    [
        'id' => 35,
        'name' => 'Creamy Tomato Sauce Pasta',
        'description' => 'A smooth, comforting pasta dish that is ready in minutes.',
        'timeMinutes' => 20,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Boil pasta in salted water.',
                'ingredients' => [
                    [
                        'id' => $ing_db['penne'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Gently heat passata with crushed garlic for 10 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['garlic_cloves'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Stir in the cream and fresh basil.',
                'ingredients' => [
                    [
                        'id' => $ing_db['double_cream'],
                        'amount' => 50,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['fresh_basil'],
                        'amount' => 10,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Toss the cooked pasta in the sauce and serve.',
            ],
        ],
        'tags' => ['pasta', 'quick', 'vegetarian'],
    ],
    [
        'id' => 36,
        'name' => 'Mango Chutney Creamy Pasta',
        'description' => 'A quirky, fusion-style sweet and savoury pasta sauce.',
        'timeMinutes' => 20,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Cook the pasta according to instructions.',
                'ingredients' => [
                    [
                        'id' => $ing_db['penne'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'In a pan, mix crème fraîche, mango chutney, and curry powder.',
                'ingredients' => [
                    [
                        'id' => $ing_db['creme_fraiche'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['mango_chutney'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['mild_curry_powder'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Warm gently—do not boil.',
            ],
            [
                'step' => 'Mix with the pasta and serve, optionally with coriander.',
            ],
        ],
        'tags' => ['fusion', 'pasta', 'unique'],
    ],
    [
        'id' => 37,
        'name' => 'Cottage and Shepherd Pie',
        'description' => 'A British staple. Use minced beef for Cottage or lamb for Shepherd.',
        'timeMinutes' => 60,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Fry meat, onion, and carrots until browned.',
                'ingredients' => [
                    [
                        'id' => $ing_db['minced_beef'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add stock and simmer for 20 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['beef_stock'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Boil and mash potatoes with butter and milk.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Place meat in a dish, top with mash, and fork the surface.',
            ],
            [
                'step' => 'Bake at 200°C for 25 minutes until the peaks are crispy.',
            ],
        ],
        'tags' => ['british', 'meat', 'pie'],
    ],
    [
        'id' => 38,
        'name' => 'Classic Creamy Fish Pie',
        'description' => 'Mixed fish and prawns in a silky white sauce topped with buttery mash.',
        'timeMinutes' => 50,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Poach fish in milk, then remove and flake. Reserve the milk.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_fish_fillet'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['salmon_fillet'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['whole_milk'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Make a white sauce using butter, flour, and the reserved milk.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Stir fish and prawns into the sauce.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cooked_prawns'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Top with mashed potatoes and bake at 200°C for 25 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
        ],
        'tags' => ['fish', 'british', 'comforting'],
    ],
    [
        'id' => 39,
        'name' => 'Bubble and Squeak',
        'description' => 'The traditional way to use up Sunday roast leftovers.',
        'timeMinutes' => 20,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Mash leftover potatoes and mix with finely chopped cooked cabbage.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 4,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Fry bacon in a pan until fat renders.',
                'ingredients' => [
                    [
                        'id' => $ing_db['bacon_rashers'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add the veg mix to the pan and press down into a cake.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Fry until a dark brown crust forms, then flip and repeat.',
            ],
        ],
        'tags' => ['british', 'leftovers', 'breakfast'],
    ],
    [
        'id' => 40,
        'name' => 'Vegetable Samosas',
        'description' => 'Crispy pastry triangles filled with spiced potatoes and peas.',
        'timeMinutes' => 45,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Boil and cube potatoes; mix with peas and spices.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_potatoes'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['frozen_peas'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['garam_masala'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['turmeric'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Cut pastry into strips, place filling at the end, and fold into triangles.',
                'ingredients' => [
                    [
                        'id' => $ing_db['phyllo_pastry'],
                        'amount' => 270,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Brush with oil and bake at 200°C for 15-20 minutes until golden.',
            ],
        ],
        'tags' => ['indian', 'snack', 'vegetarian'],
    ],
    [
        'id' => 41,
        'name' => 'Crispy Vegetable Spring Rolls',
        'description' => 'Light and crunchy appetizers filled with stir-fried vegetables.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Stir fry shredded carrots, ginger, and sprouts with soy sauce.',
                'ingredients' => [
                    [
                        'id' => $ing_db['carrot'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['fresh_ginger'],
                        'amount' => 10,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['beansprouts'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['soy_sauce'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Place filling on wrappers, roll tightly, and seal with a little water.',
                'ingredients' => [
                    [
                        'id' => $ing_db['spring_roll_wrappers'],
                        'amount' => 8,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Deep fry or brush with oil and bake until crispy.',
            ],
        ],
        'tags' => ['chinese', 'appetizer', 'vegetarian'],
    ],
    [
        'id' => 42,
        'name' => "Millionaire's Shortbread",
        'description' => 'Three layers of heaven: shortbread, gooey caramel, and thick chocolate.',
        'timeMinutes' => 90,
        'servings' => 12,
        'steps' => [
            [
                'step' => 'Rub 175g butter into flour and sugar; press into a tin and bake at 180°C for 20 mins.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 175,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 250,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['caster_sugar'],
                        'amount' => 75,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Boil remaining butter, syrup, and condensed milk (pantry) until thick and golden.',
                'ingredients' => [
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 50,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['golden_syrup'],
                        'amount' => 30,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Pour caramel over shortbread and let set.',
            ],
            [
                'step' => 'Melt chocolate and pour over the caramel. Chill until firm.',
                'ingredients' => [
                    [
                        'id' => $ing_db['dark_chocolate'],
                        'amount' => 200,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
        ],
        'tags' => ['sweet', 'baking', 'classic'],
    ],
    [
        'id' => 43,
        'name' => 'Classic Italian Tiramisu',
        'description' => 'A coffee-flavoured dessert with layers of sponge and mascarpone cream.',
        'timeMinutes' => 30,
        'servings' => 6,
        'steps' => [
            [
                'step' => 'Whisk egg yolks and sugar until pale, then fold into mascarpone.',
                'ingredients' => [
                    [
                        'id' => $ing_db['large_eggs'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['caster_sugar'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['mascarpone'],
                        'amount' => 500,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Dip biscuits quickly in coffee and layer in a dish.',
                'ingredients' => [
                    [
                        'id' => $ing_db['finger_biscuits'],
                        'amount' => 24,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['espresso'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Spread half the cream over biscuits; repeat layers.',
            ],
            [
                'step' => 'Dust with cocoa powder and chill for 4 hours.',
            ],
        ],
        'tags' => ['italian', 'dessert', 'no-bake'],
    ],
    [
        'id' => 44,
        'name' => 'Classic Prawn Cocktail',
        'description' => 'A retro starter that never goes out of style.',
        'timeMinutes' => 15,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Shred the lettuce and place in the bottom of glasses.',
                'ingredients' => [
                    [
                        'id' => $ing_db['iceberg_lettuce'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Mix mayo with a splash of ketchup (pantry), lemon juice, and paprika.',
                'ingredients' => [
                    [
                        'id' => $ing_db['mayonaisse'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['lemon_juice'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 0.5,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Toss prawns in the sauce and spoon over lettuce.',
                'ingredients' => [
                    [
                        'id' => $ing_db['cooked_prawns'],
                        'amount' => 400,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Top with a pinch of paprika and a lemon wedge.',
            ],
        ],
        'tags' => ['starter', 'seafood', 'classic'],
    ],
    [
        'id' => 45,
        'name' => 'Chicken Paprikash',
        'description' => 'A Hungarian classic of tender chicken in a smoky, creamy paprika sauce.',
        'timeMinutes' => 50,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Brown chicken thighs and remove from pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_thighs'],
                        'amount' => 6,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => "Sauté onions, then stir in paprika (don't burn it!).",
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['smoked_paprika'],
                        'amount' => 2,
                        'unit' => Units::$units_db['tbsp']
                    ],
                ]
            ],
            [
                'step' => 'Add stock and return chicken; simmer for 30 minutes.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_stock'],
                        'amount' => 300,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Stir in crème fraîche at the end and serve with noodles or rice.',
                'ingredients' => [
                    [
                        'id' => $ing_db['creme_fraiche'],
                        'amount' => 150,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
        ],
        'tags' => ['hungarian', 'chicken', 'smoky'],
    ],
    [
        'id' => 46,
        'name' => 'Spicy Chicken Jalfrezi',
        'description' => 'A vibrant stir-fried curry with peppers, onions, and green chillies.',
        'timeMinutes' => 40,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Fry chicken until sealed; remove from pan.',
                'ingredients' => [
                    [
                        'id' => $ing_db['chicken_breast'],
                        'amount' => 3,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Stir fry peppers and onions until slightly charred.',
                'ingredients' => [
                    [
                        'id' => $ing_db['red_bell_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['diced_green_bell_pepper'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Add spices, return chicken, and pour in passata.',
                'ingredients' => [
                    [
                        'id' => $ing_db['garam_masala'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['turmeric'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 200,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
            [
                'step' => 'Cook on high heat for 10 minutes until sauce is thick and coating the meat.',
            ],
        ],
        'tags' => ['indian', 'spicy', 'curry'],
    ],
    [
        'id' => 47,
        'name' => 'Soft Indian Naan Bread',
        'description' => 'Home-made flatbreads, soft and bubbly, perfect for mopping up curry sauce.',
        'timeMinutes' => 90,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Mix flour, yeast, yogurt, and warm water into a dough; knead for 10 mins.',
                'ingredients' => [
                    [
                        'id' => $ing_db['strong_bread_flour'],
                        'amount' => 250,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['yeast'],
                        'amount' => 7,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['greek_yogurt'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['butter'],
                        'amount' => 20,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Let rise for 1 hour.',
            ],
            [
                'step' => 'Divide into 4 and roll out thinly.',
            ],
            [
                'step' => 'Fry in a very hot, dry pan for 1-2 minutes each side until bubbly and charred.',
            ],
        ],
        'tags' => ['indian', 'bread', 'side'],
    ],
    [
        'id' => 48,
        'name' => 'Crispy Onion Bhajis',
        'description' => 'Spiced onion fritters, deep-fried until golden and crunchy.',
        'timeMinutes' => 30,
        'servings' => 4,
        'steps' => [
            [
                'step' => 'Thinly slice onions and toss with spices and flour.',
                'ingredients' => [
                    [
                        'id' => $ing_db['white_onion'],
                        'amount' => 2,
                        'unit' => Units::$units_db['each']
                    ],
                    [
                        'id' => $ing_db['plain_flour'],
                        'amount' => 100,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['turmeric'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                    [
                        'id' => $ing_db['ground_cumin'],
                        'amount' => 1,
                        'unit' => Units::$units_db['tsp']
                    ],
                ]
            ],
            [
                'step' => 'Add just enough water to create a thick batter that coats the onions.',
            ],
            [
                'step' => 'Drop spoonfuls into hot oil and fry for 3-4 minutes until crisp.',
                'ingredients' => [
                    [
                        'id' => $ing_db['sunflower_oil'],
                        'amount' => 500,
                        'unit' => Units::$units_db['ml']
                    ],
                ]
            ],
        ],
        'tags' => ['indian', 'snack', 'fried'],
    ],
    [
        'id' => 49,
        'name' => 'Margherita Pizza',
        'description' => 'The simple classic: tomato, mozzarella, and fresh basil.',
        'timeMinutes' => 60,
        'servings' => 2,
        'steps' => [
            [
                'step' => 'Make a dough with flour, yeast, and water; let rise.',
                'ingredients' => [
                    [
                        'id' => $ing_db['strong_bread_flour'],
                        'amount' => 300,
                        'unit' => Units::$units_db['g']
                    ],
                    [
                        'id' => $ing_db['yeast'],
                        'amount' => 7,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
            [
                'step' => 'Roll out into two thin circles.',
            ],
            [
                'step' => 'Spread passata, top with torn mozzarella.',
                'ingredients' => [
                    [
                        'id' => $ing_db['tomato_passata'],
                        'amount' => 150,
                        'unit' => Units::$units_db['ml']
                    ],
                    [
                        'id' => $ing_db['mozzarella_ball'],
                        'amount' => 1,
                        'unit' => Units::$units_db['each']
                    ],
                ]
            ],
            [
                'step' => 'Bake at the highest possible oven temp for 8-10 minutes.',
            ],
            [
                'step' => 'Top with fresh basil and a drizzle of olive oil.',
                'ingredients' => [
                    [
                        'id' => $ing_db['fresh_basil'],
                        'amount' => 5,
                        'unit' => Units::$units_db['g']
                    ],
                ]
            ],
        ],
        'tags' => ['italian', 'pizza', 'vegetarian'],
    ],

];