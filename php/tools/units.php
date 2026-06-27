<?php

require_once __DIR__ . '/../init.php';

class Units
{
    public static int $i = 1;

    public static $units_db = [];

    public static function create_units()
    {
        global $conn;
        $conn->query("DELETE FROM `Units` WHERE 1");

        Units::$i = 1; // Start sequential database IDs from 1

        // ==========================================
        // 1. COUNT / DISCRETE UNITS
        // ==========================================
        self::$units_db['each'] = new Unit(Units::$i++, '');
        self::$units_db['each']->create();


        // ==========================================
        // 2. METRIC MASS / WEIGHT UNITS
        // ==========================================

        // --- Milligram (mg) ---
        self::$units_db['mg'] = new Unit(Units::$i++, 'mg');
        self::$units_db['mg']->create();

        // --- Gram (g) ---
        self::$units_db['g'] = new Unit(Units::$i++, 'g');
        self::$units_db['g']->create();

        // --- Kilogram (kg) ---
        self::$units_db['kg'] = new Unit(Units::$i++, 'kg');
        self::$units_db['kg']->create();


        // ==========================================
        // 3. METRIC VOLUME UNITS
        // ==========================================

        // --- Milliliter (ml) ---
        self::$units_db['ml'] = new Unit(Units::$i++, 'ml');
        self::$units_db['ml']->create();

        // --- Liter (l) ---
        self::$units_db['l'] = new Unit(Units::$i++, 'l');
        self::$units_db['l']->create();


        // ==========================================
        // 4. US CUSTOMARY MASS / WEIGHT UNITS
        // ==========================================

        // --- Ounce Weight US (oz us) ---
        self::$units_db['oz_wt_us'] = new Unit(Units::$i++, 'oz (us)');
        self::$units_db['oz_wt_us']->create();

        // --- Pound US (lb us) ---
        self::$units_db['lb_us'] = new Unit(Units::$i++, 'lb (us)');
        self::$units_db['lb_us']->create();


        // ==========================================
        // 5. UK IMPERIAL MASS / WEIGHT UNITS
        // ==========================================

        // --- Ounce Weight UK (oz uk) ---
        self::$units_db['oz_wt_uk'] = new Unit(Units::$i++, 'oz (uk)');
        self::$units_db['oz_wt_uk']->create();

        // --- Pound UK (lb uk) ---
        self::$units_db['lb_uk'] = new Unit(Units::$i++, 'lb (uk)');
        self::$units_db['lb_uk']->create();

        // --- Stone UK (st uk) ---
        self::$units_db['st_uk'] = new Unit(Units::$i++, 'stone (uk)');
        self::$units_db['st_uk']->create();


        // ==========================================
        // 6. US CUSTOMARY VOLUME UNITS
        // ==========================================

        // --- Teaspoon US (tsp us) ---
        self::$units_db['tsp'] = new Unit(Units::$i++, 'tsp (us)');
        self::$units_db['tsp']->create();

        // --- Tablespoon US (tbsp us) ---
        self::$units_db['tbsp'] = new Unit(Units::$i++, 'tbsp (us)');
        self::$units_db['tbsp']->create();

        // --- Fluid Ounce US (fl oz us) ---
        self::$units_db['fl_oz_us'] = new Unit(Units::$i++, 'fl oz (us)');
        self::$units_db['fl_oz_us']->create();

        // --- Cup US (cup us) ---
        self::$units_db['cup_us'] = new Unit(Units::$i++, 'cup (us)');
        self::$units_db['cup_us']->create();

        // --- Pint US (pint us) ---
        self::$units_db['pint_us'] = new Unit(Units::$i++, 'pint (us)');
        self::$units_db['pint_us']->create();

        // --- Quart US (quart us) ---
        self::$units_db['quart_us'] = new Unit(Units::$i++, 'quart (us)');
        self::$units_db['quart_us']->create();

        // --- Gallon US (gallon us) ---
        self::$units_db['gallon_us'] = new Unit(Units::$i++, 'gallon (us)');
        self::$units_db['gallon_us']->create();


        // ==========================================
        // 7. UK IMPERIAL VOLUME UNITS
        // ==========================================

        // --- Teaspoon UK (tsp uk) ---
        self::$units_db['tsp_uk'] = new Unit(Units::$i++, 'tsp (uk)');
        self::$units_db['tsp_uk']->create();

        // --- Tablespoon UK (tbsp uk) ---
        self::$units_db['tbsp_uk'] = new Unit(Units::$i++, 'tbsp (uk)');
        self::$units_db['tbsp_uk']->create();

        // --- Fluid Ounce UK (fl oz uk) ---
        self::$units_db['fl_oz_uk'] = new Unit(Units::$i++, 'fl oz (uk)');
        self::$units_db['fl_oz_uk']->create();

        // --- Cup UK (cup uk) ---
        self::$units_db['cup_uk'] = new Unit(Units::$i++, 'cup (uk)');
        self::$units_db['cup_uk']->create();

        // --- Pint UK (pint uk) ---
        self::$units_db['pint_uk'] = new Unit(Units::$i++, 'pint (uk)');
        self::$units_db['pint_uk']->create();

        // --- Quart UK (quart uk) ---
        self::$units_db['quart_uk'] = new Unit(Units::$i++, 'quart (uk)');
        self::$units_db['quart_uk']->create();

        // --- Gallon UK (gallon uk) ---
        self::$units_db['gallon_uk'] = new Unit(Units::$i++, 'gallon (uk)');
        self::$units_db['gallon_uk']->create();


        // ==========================================
        // 8. OTHER COOKING VOLUME UNITS
        // ==========================================

        // --- Metric Cup ---
        self::$units_db['cup_metric'] = new Unit(Units::$i++, 'cup (metric)');
        self::$units_db['cup_metric']->create();

        // --- Dessertspoon ---
        self::$units_db['dessertspoon'] = new Unit(Units::$i++, 'dessertspoon');
        self::$units_db['dessertspoon']->create();

        // --- Australian Tablespoon ---
        self::$units_db['tbsp_au'] = new Unit(Units::$i++, 'tbsp (au)');
        self::$units_db['tbsp_au']->create();

        // --- Japanese Cup ---
        self::$units_db['cup_jp'] = new Unit(Units::$i++, 'cup (jp)');
        self::$units_db['cup_jp']->create();


        // ==========================================
        // CONVERSIONS & COMPATIBLE UNITS (Bidirectional)
        // Formula: unit_1 = unit_2 * multiplier
        // Bidirectional: unit_2 = unit_1 * (1 / multiplier)
        // ==========================================

        // --- Metric Weight Conversions ---
        // 1 g = 1000 mg
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['mg']->unit_id, 0.0010))->create();
        (new CompatibleUnit(self::$units_db['mg']->unit_id, self::$units_db['g']->unit_id, 1000.0000))->create();

        // 1 kg = 1000 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['kg']->unit_id, 1000.0000))->create();
        (new CompatibleUnit(self::$units_db['kg']->unit_id, self::$units_db['g']->unit_id, 0.0010))->create();


        // --- Metric Volume Conversions ---
        // 1 l = 1000 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['l']->unit_id, 1000.0000))->create();
        (new CompatibleUnit(self::$units_db['l']->unit_id, self::$units_db['ml']->unit_id, 0.0010))->create();


        // --- US Customary Weight Conversions ---
        // 1 lb (US) = 16 oz (US)
        (new CompatibleUnit(self::$units_db['oz_wt_us']->unit_id, self::$units_db['lb_us']->unit_id, 16.0000))->create();
        (new CompatibleUnit(self::$units_db['lb_us']->unit_id, self::$units_db['oz_wt_us']->unit_id, 0.0625))->create();

        // US Weight to Metric Mass
        // 1 oz (US weight) ≈ 28.3495 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['oz_wt_us']->unit_id, 28.3495))->create();
        (new CompatibleUnit(self::$units_db['oz_wt_us']->unit_id, self::$units_db['g']->unit_id, 0.03527396))->create();

        // 1 lb (US weight) ≈ 453.5924 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['lb_us']->unit_id, 453.5924))->create();
        (new CompatibleUnit(self::$units_db['lb_us']->unit_id, self::$units_db['g']->unit_id, 0.00220462))->create();


        // --- UK Imperial Weight Conversions ---
        // 1 lb (UK) = 16 oz (UK)
        (new CompatibleUnit(self::$units_db['oz_wt_uk']->unit_id, self::$units_db['lb_uk']->unit_id, 16.0000))->create();
        (new CompatibleUnit(self::$units_db['lb_uk']->unit_id, self::$units_db['oz_wt_uk']->unit_id, 0.0625))->create();

        // 1 stone (UK) = 14 lb (UK)
        (new CompatibleUnit(self::$units_db['lb_uk']->unit_id, self::$units_db['st_uk']->unit_id, 14.0000))->create();
        (new CompatibleUnit(self::$units_db['st_uk']->unit_id, self::$units_db['lb_uk']->unit_id, 0.07142857))->create();

        // UK Weight to Metric Mass
        // 1 oz (UK weight) ≈ 28.3495 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['oz_wt_uk']->unit_id, 28.3495))->create();
        (new CompatibleUnit(self::$units_db['oz_wt_uk']->unit_id, self::$units_db['g']->unit_id, 0.03527396))->create();

        // 1 lb (UK weight) ≈ 453.5924 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['lb_uk']->unit_id, 453.5924))->create();
        (new CompatibleUnit(self::$units_db['lb_uk']->unit_id, self::$units_db['g']->unit_id, 0.00220462))->create();

        // 1 stone (UK weight) ≈ 6350.2932 g
        (new CompatibleUnit(self::$units_db['g']->unit_id, self::$units_db['st_uk']->unit_id, 6350.2932))->create();
        (new CompatibleUnit(self::$units_db['st_uk']->unit_id, self::$units_db['g']->unit_id, 0.00015747))->create();


        // --- US Customary Volume Conversions ---
        // 3 tsp (US) = 1 tbsp (US)
        (new CompatibleUnit(self::$units_db['tsp']->unit_id, self::$units_db['tbsp']->unit_id, 3.0000))->create();
        (new CompatibleUnit(self::$units_db['tbsp']->unit_id, self::$units_db['tsp']->unit_id, 0.33333333))->create();

        // 2 tbsp (US) = 1 fl oz (US)
        (new CompatibleUnit(self::$units_db['tbsp']->unit_id, self::$units_db['fl_oz_us']->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$units_db['fl_oz_us']->unit_id, self::$units_db['tbsp']->unit_id, 0.5000))->create();

        // 8 fl oz (US) = 1 cup (US)
        (new CompatibleUnit(self::$units_db['fl_oz_us']->unit_id, self::$units_db['cup_us']->unit_id, 8.0000))->create();
        (new CompatibleUnit(self::$units_db['cup_us']->unit_id, self::$units_db['fl_oz_us']->unit_id, 0.1250))->create();

        // 2 cups (US) = 1 pint (US)
        (new CompatibleUnit(self::$units_db['cup_us']->unit_id, self::$units_db['pint_us']->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$units_db['pint_us']->unit_id, self::$units_db['cup_us']->unit_id, 0.5000))->create();

        // 2 pints (US) = 1 quart (US)
        (new CompatibleUnit(self::$units_db['pint_us']->unit_id, self::$units_db['quart_us']->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$units_db['quart_us']->unit_id, self::$units_db['pint_us']->unit_id, 0.5000))->create();

        // 4 quarts (US) = 1 gallon (US)
        (new CompatibleUnit(self::$units_db['quart_us']->unit_id, self::$units_db['gallon_us']->unit_id, 4.0000))->create();
        (new CompatibleUnit(self::$units_db['gallon_us']->unit_id, self::$units_db['quart_us']->unit_id, 0.2500))->create();

        // US Volume to Metric Volume
        // 1 tsp (US) ≈ 4.9289 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['tsp']->unit_id, 4.9289))->create();
        (new CompatibleUnit(self::$units_db['tsp']->unit_id, self::$units_db['ml']->unit_id, 0.20288414))->create();

        // 1 tbsp (US) ≈ 14.7868 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['tbsp']->unit_id, 14.7868))->create();
        (new CompatibleUnit(self::$units_db['tbsp']->unit_id, self::$units_db['ml']->unit_id, 0.06762805))->create();

        // 1 fl oz (US) ≈ 29.5735 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['fl_oz_us']->unit_id, 29.5735))->create();
        (new CompatibleUnit(self::$units_db['fl_oz_us']->unit_id, self::$units_db['ml']->unit_id, 0.03381402))->create();

        // 1 cup (US) ≈ 236.5882 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['cup_us']->unit_id, 236.5882))->create();
        (new CompatibleUnit(self::$units_db['cup_us']->unit_id, self::$units_db['ml']->unit_id, 0.00422675))->create();

        // 1 pint (US) ≈ 473.1765 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['pint_us']->unit_id, 473.1765))->create();
        (new CompatibleUnit(self::$units_db['pint_us']->unit_id, self::$units_db['ml']->unit_id, 0.00211338))->create();

        // 1 quart (US) ≈ 946.3529 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['quart_us']->unit_id, 946.3529))->create();
        (new CompatibleUnit(self::$units_db['quart_us']->unit_id, self::$units_db['ml']->unit_id, 0.00105669))->create();

        // 1 gallon (US) ≈ 3785.4118 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['gallon_us']->unit_id, 3785.4118))->create();
        (new CompatibleUnit(self::$units_db['gallon_us']->unit_id, self::$units_db['ml']->unit_id, 0.00026417))->create();


        // --- UK Imperial Volume Conversions ---
        // 3 tsp (UK) = 1 tbsp (UK)
        (new CompatibleUnit(self::$units_db['tsp_uk']->unit_id, self::$units_db['tbsp_uk']->unit_id, 3.0000))->create();
        (new CompatibleUnit(self::$units_db['tbsp_uk']->unit_id, self::$units_db['tsp_uk']->unit_id, 0.33333333))->create();

        // 1 cup (Imperial) = 10 fl oz (Imperial)
        (new CompatibleUnit(self::$units_db['fl_oz_uk']->unit_id, self::$units_db['cup_uk']->unit_id, 10.0000))->create();
        (new CompatibleUnit(self::$units_db['cup_uk']->unit_id, self::$units_db['fl_oz_uk']->unit_id, 0.1000))->create();

        // 20 fl oz (Imperial) = 1 pint (Imperial)
        (new CompatibleUnit(self::$units_db['fl_oz_uk']->unit_id, self::$units_db['pint_uk']->unit_id, 20.0000))->create();
        (new CompatibleUnit(self::$units_db['pint_uk']->unit_id, self::$units_db['fl_oz_uk']->unit_id, 0.0500))->create();

        // 2 pints (Imperial) = 1 quart (Imperial)
        (new CompatibleUnit(self::$units_db['pint_uk']->unit_id, self::$units_db['quart_uk']->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$units_db['quart_uk']->unit_id, self::$units_db['pint_uk']->unit_id, 0.5000))->create();

        // 4 quarts (Imperial) = 1 gallon (Imperial)
        (new CompatibleUnit(self::$units_db['quart_uk']->unit_id, self::$units_db['gallon_uk']->unit_id, 4.0000))->create();
        (new CompatibleUnit(self::$units_db['gallon_uk']->unit_id, self::$units_db['quart_uk']->unit_id, 0.2500))->create();

        // UK Imperial Volume to Metric Volume
        // 1 tsp (UK) ≈ 5.9194 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['tsp_uk']->unit_id, 5.9194))->create();
        (new CompatibleUnit(self::$units_db['tsp_uk']->unit_id, self::$units_db['ml']->unit_id, 0.16893633))->create();

        // 1 tbsp (UK) ≈ 17.7582 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['tbsp_uk']->unit_id, 17.7582))->create();
        (new CompatibleUnit(self::$units_db['tbsp_uk']->unit_id, self::$units_db['ml']->unit_id, 0.05631201))->create();

        // 1 fl oz (UK) ≈ 28.4131 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['fl_oz_uk']->unit_id, 28.4131))->create();
        (new CompatibleUnit(self::$units_db['fl_oz_uk']->unit_id, self::$units_db['ml']->unit_id, 0.03519508))->create();

        // 1 cup (UK) ≈ 284.1306 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['cup_uk']->unit_id, 284.1306))->create();
        (new CompatibleUnit(self::$units_db['cup_uk']->unit_id, self::$units_db['ml']->unit_id, 0.00351951))->create();

        // 1 pint (UK) ≈ 568.2613 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['pint_uk']->unit_id, 568.2613))->create();
        (new CompatibleUnit(self::$units_db['pint_uk']->unit_id, self::$units_db['ml']->unit_id, 0.00175975))->create();

        // 1 quart (UK) ≈ 1136.5225 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['quart_uk']->unit_id, 1136.5225))->create();
        (new CompatibleUnit(self::$units_db['quart_uk']->unit_id, self::$units_db['ml']->unit_id, 0.00087988))->create();

        // 1 gallon (UK) ≈ 4546.0900 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['gallon_uk']->unit_id, 4546.0900))->create();
        (new CompatibleUnit(self::$units_db['gallon_uk']->unit_id, self::$units_db['ml']->unit_id, 0.00021997))->create();


        // --- International & Regional Cooking Volumes to Metric ---
        // 1 cup (Metric) = 250 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['cup_metric']->unit_id, 250.0000))->create();
        (new CompatibleUnit(self::$units_db['cup_metric']->unit_id, self::$units_db['ml']->unit_id, 0.0040))->create();

        // 1 dessertspoon (UK) = 10 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['dessertspoon']->unit_id, 10.0000))->create();
        (new CompatibleUnit(self::$units_db['dessertspoon']->unit_id, self::$units_db['ml']->unit_id, 0.1000))->create();

        // 1 dessertspoon = 2 tsp (UK)
        (new CompatibleUnit(self::$units_db['tsp_uk']->unit_id, self::$units_db['dessertspoon']->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$units_db['dessertspoon']->unit_id, self::$units_db['tsp_uk']->unit_id, 0.5000))->create();

        // 1 tbsp (AU) = 20 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['tbsp_au']->unit_id, 20.0000))->create();
        (new CompatibleUnit(self::$units_db['tbsp_au']->unit_id, self::$units_db['ml']->unit_id, 0.0500))->create();

        // 1 cup (JP) = 200 ml
        (new CompatibleUnit(self::$units_db['ml']->unit_id, self::$units_db['cup_jp']->unit_id, 200.0000))->create();
        (new CompatibleUnit(self::$units_db['cup_jp']->unit_id, self::$units_db['ml']->unit_id, 0.0050))->create();
    }
}

if (null == Unit::from_id(1)) {
    Units::create_units();
} else {
    Units::$i = 1;
    
    Units::$units_db['each'] = Unit::from_id(Units::$i++);

    Units::$units_db['mg'] = Unit::from_id(Units::$i++);
    Units::$units_db['g'] = Unit::from_id(Units::$i++);
    Units::$units_db['kg'] = Unit::from_id(Units::$i++);

    Units::$units_db['ml'] = Unit::from_id(Units::$i++);
    Units::$units_db['l'] = Unit::from_id(Units::$i++);

    Units::$units_db['oz_wt_us'] = Unit::from_id(Units::$i++);
    Units::$units_db['lb_us'] = Unit::from_id(Units::$i++);

    Units::$units_db['oz_wt_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['lb_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['st_uk'] = Unit::from_id(Units::$i++);

    Units::$units_db['tsp'] = Unit::from_id(Units::$i++);
    Units::$units_db['tbsp'] = Unit::from_id(Units::$i++);
    Units::$units_db['fl_oz_us'] = Unit::from_id(Units::$i++);
    Units::$units_db['cup_us'] = Unit::from_id(Units::$i++);
    Units::$units_db['pint_us'] = Unit::from_id(Units::$i++);
    Units::$units_db['quart_us'] = Unit::from_id(Units::$i++);
    Units::$units_db['gallon_us'] = Unit::from_id(Units::$i++);

    Units::$units_db['tsp_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['tbsp_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['fl_oz_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['cup_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['pint_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['quart_uk'] = Unit::from_id(Units::$i++);
    Units::$units_db['gallon_uk'] = Unit::from_id(Units::$i++);

    Units::$units_db['cup_metric'] = Unit::from_id(Units::$i++);
    Units::$units_db['dessertspoon'] = Unit::from_id(Units::$i++);
    Units::$units_db['tbsp_au'] = Unit::from_id(Units::$i++);
    Units::$units_db['cup_jp'] = Unit::from_id(Units::$i++);
}