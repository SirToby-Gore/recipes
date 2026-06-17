<?php

require_once __DIR__ . '/../init.php';

$conn->query("DELETE FROM `Units` WHERE 1");

class Units
{
    public static int $i = 1;

    // --- 1. COUNT / DISCRETE UNITS ---
    public static Unit $each;         // standard item count (no short hand, empty symbol)

    // --- 2. METRIC MASS / WEIGHT ---
    public static Unit $mg;
    public static Unit $g;
    public static Unit $kg;

    // --- 3. METRIC VOLUME ---
    public static Unit $ml;
    public static Unit $l;

    // --- 4. US CUSTOMARY MASS / WEIGHT ---
    public static Unit $oz_wt_us;
    public static Unit $lb_us;

    // --- 5. UK IMPERIAL MASS / WEIGHT ---
    public static Unit $oz_wt_uk;
    public static Unit $lb_uk;
    public static Unit $st_uk;        // stone

    // --- 6. US CUSTOMARY VOLUME ---
    public static Unit $tsp;
    public static Unit $tbsp;
    public static Unit $fl_oz_us;
    public static Unit $cup_us;
    public static Unit $pint_us;
    public static Unit $quart_us;
    public static Unit $gallon_us;

    // --- 7. UK IMPERIAL VOLUME ---
    public static Unit $tsp_uk;
    public static Unit $tbsp_uk;
    public static Unit $fl_oz_uk;
    public static Unit $cup_uk;
    public static Unit $pint_uk;
    public static Unit $quart_uk;
    public static Unit $gallon_uk;

    // --- 8. OTHER COOKING VOLUMES ---
    public static Unit $cup_metric;
    public static Unit $dessertspoon; // common UK cooking spoon
    public static Unit $tbsp_au;      // Australian tablespoon (20ml)
    public static Unit $cup_jp;        // Japanese cup (200ml)

    public static function create_units()
    {
        self::$i = 1; // Start sequential database IDs from 1

        // ==========================================
        // 1. COUNT / DISCRETE UNITS
        // ==========================================
        self::$each = new Unit(self::$i++, '');
        self::$each->create();


        // ==========================================
        // 2. METRIC MASS / WEIGHT UNITS
        // ==========================================

        // --- Milligram (mg) ---
        self::$mg = new Unit(self::$i++, 'mg');
        self::$mg->create();

        // --- Gram (g) ---
        self::$g = new Unit(self::$i++, 'g');
        self::$g->create();

        // --- Kilogram (kg) ---
        self::$kg = new Unit(self::$i++, 'kg');
        self::$kg->create();


        // ==========================================
        // 3. METRIC VOLUME UNITS
        // ==========================================

        // --- Milliliter (ml) ---
        self::$ml = new Unit(self::$i++, 'ml');
        self::$ml->create();

        // --- Liter (l) ---
        self::$l = new Unit(self::$i++, 'l');
        self::$l->create();


        // ==========================================
        // 4. US CUSTOMARY MASS / WEIGHT UNITS
        // ==========================================

        // --- Ounce Weight US (oz us) ---
        self::$oz_wt_us = new Unit(self::$i++, 'oz (us)');
        self::$oz_wt_us->create();

        // --- Pound US (lb us) ---
        self::$lb_us = new Unit(self::$i++, 'lb (us)');
        self::$lb_us->create();


        // ==========================================
        // 5. UK IMPERIAL MASS / WEIGHT UNITS
        // ==========================================

        // --- Ounce Weight UK (oz uk) ---
        self::$oz_wt_uk = new Unit(self::$i++, 'oz (uk)');
        self::$oz_wt_uk->create();

        // --- Pound UK (lb uk) ---
        self::$lb_uk = new Unit(self::$i++, 'lb (uk)');
        self::$lb_uk->create();

        // --- Stone UK (st uk) ---
        self::$st_uk = new Unit(self::$i++, 'stone (uk)');
        self::$st_uk->create();


        // ==========================================
        // 6. US CUSTOMARY VOLUME UNITS
        // ==========================================

        // --- Teaspoon US (tsp us) ---
        self::$tsp = new Unit(self::$i++, 'tsp (us)');
        self::$tsp->create();

        // --- Tablespoon US (tbsp us) ---
        self::$tbsp = new Unit(self::$i++, 'tbsp (us)');
        self::$tbsp->create();

        // --- Fluid Ounce US (fl oz us) ---
        self::$fl_oz_us = new Unit(self::$i++, 'fl oz (us)');
        self::$fl_oz_us->create();

        // --- Cup US (cup us) ---
        self::$cup_us = new Unit(self::$i++, 'cup (us)');
        self::$cup_us->create();

        // --- Pint US (pint us) ---
        self::$pint_us = new Unit(self::$i++, 'pint (us)');
        self::$pint_us->create();

        // --- Quart US (quart us) ---
        self::$quart_us = new Unit(self::$i++, 'quart (us)');
        self::$quart_us->create();

        // --- Gallon US (gallon us) ---
        self::$gallon_us = new Unit(self::$i++, 'gallon (us)');
        self::$gallon_us->create();


        // ==========================================
        // 7. UK IMPERIAL VOLUME UNITS
        // ==========================================

        // --- Teaspoon UK (tsp uk) ---
        self::$tsp_uk = new Unit(self::$i++, 'tsp (uk)');
        self::$tsp_uk->create();

        // --- Tablespoon UK (tbsp uk) ---
        self::$tbsp_uk = new Unit(self::$i++, 'tbsp (uk)');
        self::$tbsp_uk->create();

        // --- Fluid Ounce UK (fl oz uk) ---
        self::$fl_oz_uk = new Unit(self::$i++, 'fl oz (uk)');
        self::$fl_oz_uk->create();

        // --- Cup UK (cup uk) ---
        self::$cup_uk = new Unit(self::$i++, 'cup (uk)');
        self::$cup_uk->create();

        // --- Pint UK (pint uk) ---
        self::$pint_uk = new Unit(self::$i++, 'pint (uk)');
        self::$pint_uk->create();

        // --- Quart UK (quart uk) ---
        self::$quart_uk = new Unit(self::$i++, 'quart (uk)');
        self::$quart_uk->create();

        // --- Gallon UK (gallon uk) ---
        self::$gallon_uk = new Unit(self::$i++, 'gallon (uk)');
        self::$gallon_uk->create();


        // ==========================================
        // 8. OTHER COOKING VOLUME UNITS
        // ==========================================

        // --- Metric Cup ---
        self::$cup_metric = new Unit(self::$i++, 'cup (metric)');
        self::$cup_metric->create();

        // --- Dessertspoon ---
        self::$dessertspoon = new Unit(self::$i++, 'dessertspoon');
        self::$dessertspoon->create();

        // --- Australian Tablespoon ---
        self::$tbsp_au = new Unit(self::$i++, 'tbsp (au)');
        self::$tbsp_au->create();

        // --- Japanese Cup ---
        self::$cup_jp = new Unit(self::$i++, 'cup (jp)');
        self::$cup_jp->create();


        // ==========================================
        // CONVERSIONS & COMPATIBLE UNITS (Bidirectional)
        // Formula: unit_1 = unit_2 * multiplier
        // Bidirectional: unit_2 = unit_1 * (1 / multiplier)
        // ==========================================

        // --- Metric Weight Conversions ---
        // 1 g = 1000 mg
        (new CompatibleUnit(self::$g->unit_id, self::$mg->unit_id, 0.0010))->create();
        (new CompatibleUnit(self::$mg->unit_id, self::$g->unit_id, 1000.0000))->create();

        // 1 kg = 1000 g
        (new CompatibleUnit(self::$g->unit_id, self::$kg->unit_id, 1000.0000))->create();
        (new CompatibleUnit(self::$kg->unit_id, self::$g->unit_id, 0.0010))->create();


        // --- Metric Volume Conversions ---
        // 1 l = 1000 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$l->unit_id, 1000.0000))->create();
        (new CompatibleUnit(self::$l->unit_id, self::$ml->unit_id, 0.0010))->create();


        // --- US Customary Weight Conversions ---
        // 1 lb (US) = 16 oz (US)
        (new CompatibleUnit(self::$oz_wt_us->unit_id, self::$lb_us->unit_id, 16.0000))->create();
        (new CompatibleUnit(self::$lb_us->unit_id, self::$oz_wt_us->unit_id, 0.0625))->create();

        // US Weight to Metric Mass
        // 1 oz (US weight) ≈ 28.3495 g
        (new CompatibleUnit(self::$g->unit_id, self::$oz_wt_us->unit_id, 28.3495))->create();
        (new CompatibleUnit(self::$oz_wt_us->unit_id, self::$g->unit_id, 0.03527396))->create();

        // 1 lb (US weight) ≈ 453.5924 g
        (new CompatibleUnit(self::$g->unit_id, self::$lb_us->unit_id, 453.5924))->create();
        (new CompatibleUnit(self::$lb_us->unit_id, self::$g->unit_id, 0.00220462))->create();


        // --- UK Imperial Weight Conversions ---
        // 1 lb (UK) = 16 oz (UK)
        (new CompatibleUnit(self::$oz_wt_uk->unit_id, self::$lb_uk->unit_id, 16.0000))->create();
        (new CompatibleUnit(self::$lb_uk->unit_id, self::$oz_wt_uk->unit_id, 0.0625))->create();

        // 1 stone (UK) = 14 lb (UK)
        (new CompatibleUnit(self::$lb_uk->unit_id, self::$st_uk->unit_id, 14.0000))->create();
        (new CompatibleUnit(self::$st_uk->unit_id, self::$lb_uk->unit_id, 0.07142857))->create();

        // UK Weight to Metric Mass
        // 1 oz (UK weight) ≈ 28.3495 g
        (new CompatibleUnit(self::$g->unit_id, self::$oz_wt_uk->unit_id, 28.3495))->create();
        (new CompatibleUnit(self::$oz_wt_uk->unit_id, self::$g->unit_id, 0.03527396))->create();

        // 1 lb (UK weight) ≈ 453.5924 g
        (new CompatibleUnit(self::$g->unit_id, self::$lb_uk->unit_id, 453.5924))->create();
        (new CompatibleUnit(self::$lb_uk->unit_id, self::$g->unit_id, 0.00220462))->create();

        // 1 stone (UK weight) ≈ 6350.2932 g
        (new CompatibleUnit(self::$g->unit_id, self::$st_uk->unit_id, 6350.2932))->create();
        (new CompatibleUnit(self::$st_uk->unit_id, self::$g->unit_id, 0.00015747))->create();


        // --- US Customary Volume Conversions ---
        // 3 tsp (US) = 1 tbsp (US)
        (new CompatibleUnit(self::$tsp->unit_id, self::$tbsp->unit_id, 3.0000))->create();
        (new CompatibleUnit(self::$tbsp->unit_id, self::$tsp->unit_id, 0.33333333))->create();

        // 2 tbsp (US) = 1 fl oz (US)
        (new CompatibleUnit(self::$tbsp->unit_id, self::$fl_oz_us->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$fl_oz_us->unit_id, self::$tbsp->unit_id, 0.5000))->create();

        // 8 fl oz (US) = 1 cup (US)
        (new CompatibleUnit(self::$fl_oz_us->unit_id, self::$cup_us->unit_id, 8.0000))->create();
        (new CompatibleUnit(self::$cup_us->unit_id, self::$fl_oz_us->unit_id, 0.1250))->create();

        // 2 cups (US) = 1 pint (US)
        (new CompatibleUnit(self::$cup_us->unit_id, self::$pint_us->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$pint_us->unit_id, self::$cup_us->unit_id, 0.5000))->create();

        // 2 pints (US) = 1 quart (US)
        (new CompatibleUnit(self::$pint_us->unit_id, self::$quart_us->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$quart_us->unit_id, self::$pint_us->unit_id, 0.5000))->create();

        // 4 quarts (US) = 1 gallon (US)
        (new CompatibleUnit(self::$quart_us->unit_id, self::$gallon_us->unit_id, 4.0000))->create();
        (new CompatibleUnit(self::$gallon_us->unit_id, self::$quart_us->unit_id, 0.2500))->create();

        // US Volume to Metric Volume
        // 1 tsp (US) ≈ 4.9289 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$tsp->unit_id, 4.9289))->create();
        (new CompatibleUnit(self::$tsp->unit_id, self::$ml->unit_id, 0.20288414))->create();

        // 1 tbsp (US) ≈ 14.7868 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$tbsp->unit_id, 14.7868))->create();
        (new CompatibleUnit(self::$tbsp->unit_id, self::$ml->unit_id, 0.06762805))->create();

        // 1 fl oz (US) ≈ 29.5735 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$fl_oz_us->unit_id, 29.5735))->create();
        (new CompatibleUnit(self::$fl_oz_us->unit_id, self::$ml->unit_id, 0.03381402))->create();

        // 1 cup (US) ≈ 236.5882 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$cup_us->unit_id, 236.5882))->create();
        (new CompatibleUnit(self::$cup_us->unit_id, self::$ml->unit_id, 0.00422675))->create();

        // 1 pint (US) ≈ 473.1765 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$pint_us->unit_id, 473.1765))->create();
        (new CompatibleUnit(self::$pint_us->unit_id, self::$ml->unit_id, 0.00211338))->create();

        // 1 quart (US) ≈ 946.3529 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$quart_us->unit_id, 946.3529))->create();
        (new CompatibleUnit(self::$quart_us->unit_id, self::$ml->unit_id, 0.00105669))->create();

        // 1 gallon (US) ≈ 3785.4118 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$gallon_us->unit_id, 3785.4118))->create();
        (new CompatibleUnit(self::$gallon_us->unit_id, self::$ml->unit_id, 0.00026417))->create();


        // --- UK Imperial Volume Conversions ---
        // 3 tsp (UK) = 1 tbsp (UK)
        (new CompatibleUnit(self::$tsp_uk->unit_id, self::$tbsp_uk->unit_id, 3.0000))->create();
        (new CompatibleUnit(self::$tbsp_uk->unit_id, self::$tsp_uk->unit_id, 0.33333333))->create();

        // 1 cup (Imperial) = 10 fl oz (Imperial)
        (new CompatibleUnit(self::$fl_oz_uk->unit_id, self::$cup_uk->unit_id, 10.0000))->create();
        (new CompatibleUnit(self::$cup_uk->unit_id, self::$fl_oz_uk->unit_id, 0.1000))->create();

        // 20 fl oz (Imperial) = 1 pint (Imperial)
        (new CompatibleUnit(self::$fl_oz_uk->unit_id, self::$pint_uk->unit_id, 20.0000))->create();
        (new CompatibleUnit(self::$pint_uk->unit_id, self::$fl_oz_uk->unit_id, 0.0500))->create();

        // 2 pints (Imperial) = 1 quart (Imperial)
        (new CompatibleUnit(self::$pint_uk->unit_id, self::$quart_uk->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$quart_uk->unit_id, self::$pint_uk->unit_id, 0.5000))->create();

        // 4 quarts (Imperial) = 1 gallon (Imperial)
        (new CompatibleUnit(self::$quart_uk->unit_id, self::$gallon_uk->unit_id, 4.0000))->create();
        (new CompatibleUnit(self::$gallon_uk->unit_id, self::$quart_uk->unit_id, 0.2500))->create();

        // UK Imperial Volume to Metric Volume
        // 1 tsp (UK) ≈ 5.9194 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$tsp_uk->unit_id, 5.9194))->create();
        (new CompatibleUnit(self::$tsp_uk->unit_id, self::$ml->unit_id, 0.16893633))->create();

        // 1 tbsp (UK) ≈ 17.7582 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$tbsp_uk->unit_id, 17.7582))->create();
        (new CompatibleUnit(self::$tbsp_uk->unit_id, self::$ml->unit_id, 0.05631201))->create();

        // 1 fl oz (UK) ≈ 28.4131 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$fl_oz_uk->unit_id, 28.4131))->create();
        (new CompatibleUnit(self::$fl_oz_uk->unit_id, self::$ml->unit_id, 0.03519508))->create();

        // 1 cup (UK) ≈ 284.1306 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$cup_uk->unit_id, 284.1306))->create();
        (new CompatibleUnit(self::$cup_uk->unit_id, self::$ml->unit_id, 0.00351951))->create();

        // 1 pint (UK) ≈ 568.2613 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$pint_uk->unit_id, 568.2613))->create();
        (new CompatibleUnit(self::$pint_uk->unit_id, self::$ml->unit_id, 0.00175975))->create();

        // 1 quart (UK) ≈ 1136.5225 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$quart_uk->unit_id, 1136.5225))->create();
        (new CompatibleUnit(self::$quart_uk->unit_id, self::$ml->unit_id, 0.00087988))->create();

        // 1 gallon (UK) ≈ 4546.0900 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$gallon_uk->unit_id, 4546.0900))->create();
        (new CompatibleUnit(self::$gallon_uk->unit_id, self::$ml->unit_id, 0.00021997))->create();


        // --- International & Regional Cooking Volumes to Metric ---
        // 1 cup (Metric) = 250 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$cup_metric->unit_id, 250.0000))->create();
        (new CompatibleUnit(self::$cup_metric->unit_id, self::$ml->unit_id, 0.0040))->create();

        // 1 dessertspoon (UK) = 10 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$dessertspoon->unit_id, 10.0000))->create();
        (new CompatibleUnit(self::$dessertspoon->unit_id, self::$ml->unit_id, 0.1000))->create();

        // 1 dessertspoon = 2 tsp (UK)
        (new CompatibleUnit(self::$tsp_uk->unit_id, self::$dessertspoon->unit_id, 2.0000))->create();
        (new CompatibleUnit(self::$dessertspoon->unit_id, self::$tsp_uk->unit_id, 0.5000))->create();

        // 1 tbsp (AU) = 20 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$tbsp_au->unit_id, 20.0000))->create();
        (new CompatibleUnit(self::$tbsp_au->unit_id, self::$ml->unit_id, 0.0500))->create();

        // 1 cup (JP) = 200 ml
        (new CompatibleUnit(self::$ml->unit_id, self::$cup_jp->unit_id, 200.0000))->create();
        (new CompatibleUnit(self::$cup_jp->unit_id, self::$ml->unit_id, 0.0050))->create();
    }
}

if (null == Unit::from_id(1)) {
    Units::create_units();
} else {
    Units::$each = Unit::from_id(Units::$i++);

    Units::$mg = Unit::from_id(Units::$i++);
    Units::$g = Unit::from_id(Units::$i++);
    Units::$kg = Unit::from_id(Units::$i++);

    Units::$ml = Unit::from_id(Units::$i++);
    Units::$l = Unit::from_id(Units::$i++);

    Units::$oz_wt_us = Unit::from_id(Units::$i++);
    Units::$lb_us = Unit::from_id(Units::$i++);

    Units::$oz_wt_uk = Unit::from_id(Units::$i++);
    Units::$lb_uk = Unit::from_id(Units::$i++);
    Units::$st_uk = Unit::from_id(Units::$i++);

    Units::$tsp = Unit::from_id(Units::$i++);
    Units::$tbsp = Unit::from_id(Units::$i++);
    Units::$fl_oz_us = Unit::from_id(Units::$i++);
    Units::$cup_us = Unit::from_id(Units::$i++);
    Units::$pint_us = Unit::from_id(Units::$i++);
    Units::$quart_us = Unit::from_id(Units::$i++);
    Units::$gallon_us = Unit::from_id(Units::$i++);

    Units::$tsp_uk = Unit::from_id(Units::$i++);
    Units::$tbsp_uk = Unit::from_id(Units::$i++);
    Units::$fl_oz_uk = Unit::from_id(Units::$i++);
    Units::$cup_uk = Unit::from_id(Units::$i++);
    Units::$pint_uk = Unit::from_id(Units::$i++);
    Units::$quart_uk = Unit::from_id(Units::$i++);
    Units::$gallon_uk = Unit::from_id(Units::$i++);

    Units::$cup_metric = Unit::from_id(Units::$i++);
    Units::$dessertspoon = Unit::from_id(Units::$i++);
    Units::$tbsp_au = Unit::from_id(Units::$i++);
    Units::$cup_jp = Unit::from_id(Units::$i++);
}