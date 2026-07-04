<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * IMPORTANT: The macros below are ballpark estimates for typical serving
 * sizes, compiled for a starter dataset -- they are NOT pulled directly
 * from the FNRI Philippine Food Composition Tables (PFCT). Raw
 * fruits/vegetables are close to standard nutrition-table values; composite
 * ulam/dessert/snack dishes are estimates based on typical recipes and
 * serving sizes, since FNRI PFCT catalogs ingredients, not composite Filipino
 * dishes.
 *
 * Before this ships to real users tracking their intake, cross-check each
 * entry against the official FNRI PFCT (https://i.fnri.dost.gov.ph/) or
 * another verified source, and flip `source` from 'estimated' to
 * 'FNRI PFCT' once confirmed. Treat this seeder as scaffolding, not a
 * nutrition-accurate dataset.
 *
 * Total entries: 358
 */
class FilipinoFoodSeeder extends Seeder
{
    public function run(): void
    {
        $dishes = [
            // --- Ulam ---
            ['name' => 'Chicken Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 25, 'carb' => 6, 'fat' => 18, 'aliases' => ['adobong manok']],
            ['name' => 'Pork Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 350, 'pro' => 22, 'carb' => 6, 'fat' => 26, 'aliases' => ['adobong baboy']],
            // --- Soup ---
            ['name' => 'Sinigang na Baboy', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 250, 'pro' => 18, 'carb' => 10, 'fat' => 15, 'aliases' => ['pork sinigang']],
            ['name' => 'Sinigang na Hipon', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 180, 'pro' => 16, 'carb' => 10, 'fat' => 8, 'aliases' => ['shrimp sinigang']],
            // --- Ulam ---
            ['name' => 'Pork Sisig', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 430, 'pro' => 25, 'carb' => 8, 'fat' => 33, 'aliases' => []],
            ['name' => 'Lechon Kawali', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 400, 'pro' => 22, 'carb' => 0, 'fat' => 34, 'aliases' => []],
            ['name' => 'Kare-Kare', 'category' => 'Ulam', 'serving' => '1 cup (~250g, no rice)', 'cal' => 380, 'pro' => 20, 'carb' => 15, 'fat' => 27, 'aliases' => []],
            // --- Soup ---
            ['name' => 'Bulalo', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 320, 'pro' => 28, 'carb' => 8, 'fat' => 20, 'aliases' => ['beef bulalo']],
            ['name' => 'Chicken Tinola', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 200, 'pro' => 22, 'carb' => 8, 'fat' => 8, 'aliases' => ['tinolang manok']],
            // --- Ulam ---
            ['name' => 'Pork Menudo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 18, 'carb' => 15, 'fat' => 16, 'aliases' => []],
            ['name' => 'Chicken Caldereta', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 19, 'carb' => 13, 'fat' => 18, 'aliases' => ['kaldereta']],
            ['name' => 'Beef Caldereta', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 22, 'carb' => 12, 'fat' => 22, 'aliases' => ['kaldereta']],
            ['name' => 'Bicol Express', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 350, 'pro' => 15, 'carb' => 8, 'fat' => 28, 'aliases' => []],
            ['name' => 'Laing', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 220, 'pro' => 6, 'carb' => 10, 'fat' => 18, 'aliases' => []],
            ['name' => 'Dinuguan', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 18, 'carb' => 8, 'fat' => 20, 'aliases' => []],
            // --- Snack ---
            ['name' => 'Chicharon', 'category' => 'Snack', 'serving' => '30 g', 'cal' => 165, 'pro' => 14, 'carb' => 0, 'fat' => 12, 'aliases' => ['chicharon baboy']],
            // --- Noodles ---
            ['name' => 'Pancit Canton', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 10, 'carb' => 40, 'fat' => 9, 'aliases' => []],
            ['name' => 'Pancit Bihon', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 250, 'pro' => 8, 'carb' => 42, 'fat' => 6, 'aliases' => []],
            // --- Snack ---
            ['name' => 'Lumpiang Shanghai', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 220, 'pro' => 9, 'carb' => 18, 'fat' => 12, 'aliases' => ['shanghai']],
            ['name' => 'Lumpiang Sariwa', 'category' => 'Snack', 'serving' => '2 pieces', 'cal' => 150, 'pro' => 5, 'carb' => 20, 'fat' => 6, 'aliases' => []],
            // --- Ulam ---
            ['name' => 'Chicken Inasal', 'category' => 'Ulam', 'serving' => '1 piece (thigh-leg)', 'cal' => 300, 'pro' => 28, 'carb' => 3, 'fat' => 19, 'aliases' => ['inasal']],
            // --- Breakfast ---
            ['name' => 'Longganisa', 'category' => 'Breakfast', 'serving' => '2 links (~70g)', 'cal' => 220, 'pro' => 10, 'carb' => 8, 'fat' => 16, 'aliases' => []],
            ['name' => 'Beef Tapa', 'category' => 'Breakfast', 'serving' => '100 g', 'cal' => 250, 'pro' => 24, 'carb' => 4, 'fat' => 15, 'aliases' => ['tapa']],
            ['name' => 'Pork Tocino', 'category' => 'Breakfast', 'serving' => '100 g', 'cal' => 260, 'pro' => 16, 'carb' => 12, 'fat' => 16, 'aliases' => ['tocino']],
            ['name' => 'Champorado', 'category' => 'Breakfast', 'serving' => '1 bowl (~250g)', 'cal' => 220, 'pro' => 4, 'carb' => 42, 'fat' => 4, 'aliases' => []],
            // --- Soup ---
            ['name' => 'Arroz Caldo', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 280, 'pro' => 14, 'carb' => 38, 'fat' => 8, 'aliases' => []],
            ['name' => 'Goto', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 250, 'pro' => 12, 'carb' => 35, 'fat' => 7, 'aliases' => []],
            // --- Noodles ---
            ['name' => 'Batchoy', 'category' => 'Noodles', 'serving' => '1 bowl (~350g)', 'cal' => 350, 'pro' => 18, 'carb' => 40, 'fat' => 14, 'aliases' => ['la paz batchoy']],
            ['name' => 'Palabok', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 320, 'pro' => 12, 'carb' => 45, 'fat' => 10, 'aliases' => ['pancit palabok']],
            // --- Rice ---
            ['name' => 'Sinangag', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 250, 'pro' => 4, 'carb' => 40, 'fat' => 8, 'aliases' => ['garlic fried rice']],
            ['name' => 'Plain Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 205, 'pro' => 4, 'carb' => 45, 'fat' => 0.4, 'aliases' => ['kanin']],
            // --- Dessert ---
            ['name' => 'Halo-Halo', 'category' => 'Dessert', 'serving' => '1 serving', 'cal' => 350, 'pro' => 5, 'carb' => 65, 'fat' => 8, 'aliases' => []],
            ['name' => 'Turon', 'category' => 'Dessert', 'serving' => '2 pieces', 'cal' => 220, 'pro' => 2, 'carb' => 38, 'fat' => 8, 'aliases' => []],
            ['name' => 'Puto', 'category' => 'Dessert', 'serving' => '3 pieces', 'cal' => 150, 'pro' => 3, 'carb' => 32, 'fat' => 1, 'aliases' => []],
            ['name' => 'Bibingka', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 200, 'pro' => 4, 'carb' => 32, 'fat' => 6, 'aliases' => []],
            // --- Snack ---
            ['name' => 'Taho', 'category' => 'Snack', 'serving' => '1 cup', 'cal' => 180, 'pro' => 8, 'carb' => 30, 'fat' => 3, 'aliases' => []],
            ['name' => 'Ensaymada', 'category' => 'Snack', 'serving' => '1 piece', 'cal' => 300, 'pro' => 6, 'carb' => 40, 'fat' => 13, 'aliases' => []],
            // --- Soup ---
            ['name' => 'Beef Nilaga', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 300, 'pro' => 26, 'carb' => 10, 'fat' => 18, 'aliases' => ['nilagang baka']],
            ['name' => 'Pork Nilaga', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 280, 'pro' => 22, 'carb' => 10, 'fat' => 17, 'aliases' => ['nilagang baboy']],
            // --- Vegetable ---
            ['name' => 'Pinakbet', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 180, 'pro' => 8, 'carb' => 14, 'fat' => 10, 'aliases' => []],
            ['name' => 'Ginataang Kalabasa', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 200, 'pro' => 6, 'carb' => 16, 'fat' => 14, 'aliases' => ['ginataang squash']],
            // --- Ulam ---
            ['name' => 'Ginisang Munggo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 220, 'pro' => 12, 'carb' => 22, 'fat' => 10, 'aliases' => ['munggo guisado']],
            ['name' => 'Tortang Talong', 'category' => 'Ulam', 'serving' => '1 piece (~120g)', 'cal' => 180, 'pro' => 8, 'carb' => 10, 'fat' => 12, 'aliases' => ['eggplant omelet']],
            ['name' => 'Bistek Tagalog', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 320, 'pro' => 24, 'carb' => 10, 'fat' => 20, 'aliases' => ['beef steak']],
            ['name' => 'Pork Steak', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 22, 'carb' => 10, 'fat' => 24, 'aliases' => []],
            ['name' => 'Chicken Afritada', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 290, 'pro' => 19, 'carb' => 14, 'fat' => 17, 'aliases' => ['afritadang manok']],
            ['name' => 'Beef Afritada', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 330, 'pro' => 22, 'carb' => 13, 'fat' => 21, 'aliases' => []],
            ['name' => 'Adobong Pusit', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 250, 'pro' => 20, 'carb' => 8, 'fat' => 15, 'aliases' => ['squid adobo']],
            ['name' => 'Ginataang Manok', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 22, 'carb' => 8, 'fat' => 25, 'aliases' => ['bicol style chicken']],
            ['name' => 'Pork Barbecue', 'category' => 'Ulam', 'serving' => '2 sticks (~150g)', 'cal' => 320, 'pro' => 24, 'carb' => 12, 'fat' => 20, 'aliases' => ['pork bbq']],
            ['name' => 'Crispy Pata', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 420, 'pro' => 24, 'carb' => 2, 'fat' => 35, 'aliases' => []],
            ['name' => 'Bopis', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 18, 'carb' => 6, 'fat' => 20, 'aliases' => []],
            ['name' => 'Escabeche', 'category' => 'Ulam', 'serving' => '1 piece fish (~150g)', 'cal' => 260, 'pro' => 20, 'carb' => 18, 'fat' => 12, 'aliases' => ['sweet and sour fish']],
            // --- Breakfast ---
            ['name' => 'Daing na Bangus', 'category' => 'Breakfast', 'serving' => '1 piece (~150g)', 'cal' => 250, 'pro' => 24, 'carb' => 2, 'fat' => 16, 'aliases' => []],
            ['name' => 'Tinapa', 'category' => 'Breakfast', 'serving' => '100 g', 'cal' => 180, 'pro' => 22, 'carb' => 0, 'fat' => 9, 'aliases' => ['smoked fish']],
            ['name' => 'Pandesal', 'category' => 'Breakfast', 'serving' => '3 pieces', 'cal' => 250, 'pro' => 7, 'carb' => 45, 'fat' => 5, 'aliases' => []],
            // --- Dessert ---
            ['name' => 'Kutsinta', 'category' => 'Dessert', 'serving' => '3 pieces', 'cal' => 180, 'pro' => 2, 'carb' => 38, 'fat' => 2, 'aliases' => []],
            ['name' => 'Sapin-Sapin', 'category' => 'Dessert', 'serving' => '1 slice (~100g)', 'cal' => 220, 'pro' => 3, 'carb' => 40, 'fat' => 6, 'aliases' => []],
            ['name' => 'Leche Flan', 'category' => 'Dessert', 'serving' => '1 slice (~90g)', 'cal' => 250, 'pro' => 6, 'carb' => 35, 'fat' => 10, 'aliases' => []],
            ['name' => 'Buko Pie', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 300, 'pro' => 4, 'carb' => 38, 'fat' => 15, 'aliases' => []],
            // --- Snack ---
            ['name' => 'Banana Cue', 'category' => 'Snack', 'serving' => '2 sticks', 'cal' => 220, 'pro' => 1, 'carb' => 48, 'fat' => 4, 'aliases' => []],
            ['name' => 'Camote Cue', 'category' => 'Snack', 'serving' => '2 sticks', 'cal' => 200, 'pro' => 1, 'carb' => 42, 'fat' => 4, 'aliases' => []],
            ['name' => 'Kwek-Kwek', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 300, 'pro' => 12, 'carb' => 22, 'fat' => 18, 'aliases' => ['quail egg fritters']],
            ['name' => 'Isaw', 'category' => 'Snack', 'serving' => '5 sticks (~150g)', 'cal' => 280, 'pro' => 18, 'carb' => 2, 'fat' => 22, 'aliases' => ['grilled chicken intestines']],
            ['name' => 'Fish Balls', 'category' => 'Snack', 'serving' => '10 pieces', 'cal' => 220, 'pro' => 10, 'carb' => 20, 'fat' => 11, 'aliases' => []],
            // --- Dessert ---
            ['name' => 'Mais con Yelo', 'category' => 'Dessert', 'serving' => '1 serving', 'cal' => 250, 'pro' => 4, 'carb' => 48, 'fat' => 5, 'aliases' => ['corn with ice']],
            // --- Beverage ---
            ['name' => 'Sago\'t Gulaman', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 180, 'pro' => 0, 'carb' => 45, 'fat' => 0, 'aliases' => []],
            ['name' => 'Calamansi Juice', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 90, 'pro' => 0, 'carb' => 22, 'fat' => 0, 'aliases' => ['calamansi juice, sweetened']],
            // --- Ulam ---
            ['name' => 'Pork Humba', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 350, 'pro' => 20, 'carb' => 12, 'fat' => 24, 'aliases' => []],
            ['name' => 'Pork Estofado', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 20, 'carb' => 15, 'fat' => 22, 'aliases' => []],
            ['name' => 'Beef Mechado', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 330, 'pro' => 24, 'carb' => 12, 'fat' => 20, 'aliases' => []],
            ['name' => 'Beef Estofado', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 23, 'carb' => 14, 'fat' => 21, 'aliases' => []],
            ['name' => 'Pork Igado', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 22, 'carb' => 8, 'fat' => 18, 'aliases' => []],
            ['name' => 'Relyenong Manok', 'category' => 'Ulam', 'serving' => '1 slice (~150g)', 'cal' => 380, 'pro' => 26, 'carb' => 10, 'fat' => 24, 'aliases' => ['stuffed chicken']],
            ['name' => 'Lechon Manok', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 280, 'pro' => 26, 'carb' => 0, 'fat' => 18, 'aliases' => ['roast chicken']],
            ['name' => 'Lechon Baboy', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 400, 'pro' => 24, 'carb' => 0, 'fat' => 33, 'aliases' => ['roast pig']],
            ['name' => 'Chicken Barbecue', 'category' => 'Ulam', 'serving' => '2 sticks (~150g)', 'cal' => 300, 'pro' => 26, 'carb' => 8, 'fat' => 17, 'aliases' => ['chicken bbq']],
            ['name' => 'Betamax', 'category' => 'Ulam', 'serving' => '5 sticks (~150g)', 'cal' => 220, 'pro' => 16, 'carb' => 2, 'fat' => 16, 'aliases' => ['grilled chicken blood cubes']],
            ['name' => 'Proben', 'category' => 'Ulam', 'serving' => '5 sticks (~150g)', 'cal' => 200, 'pro' => 18, 'carb' => 2, 'fat' => 13, 'aliases' => []],
            ['name' => 'Chicken Liver Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 260, 'pro' => 22, 'carb' => 6, 'fat' => 16, 'aliases' => []],
            ['name' => 'Pork Liempo Inihaw', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 380, 'pro' => 20, 'carb' => 0, 'fat' => 32, 'aliases' => ['grilled pork belly']],
            ['name' => 'Bagnet', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 420, 'pro' => 20, 'carb' => 2, 'fat' => 36, 'aliases' => ['ilocano crispy pork']],
            ['name' => 'Dinardaraan', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 18, 'carb' => 6, 'fat' => 20, 'aliases' => ['ilocano blood stew']],
            ['name' => 'Poqui-Poqui', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 170, 'pro' => 7, 'carb' => 10, 'fat' => 11, 'aliases' => ['ilocano eggplant omelet']],
            ['name' => 'Pork Binagoongan', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 20, 'carb' => 8, 'fat' => 24, 'aliases' => []],
            ['name' => 'Beef Kilawin', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 240, 'pro' => 24, 'carb' => 4, 'fat' => 14, 'aliases' => []],
            ['name' => 'Chicken Pastel', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 20, 'carb' => 14, 'fat' => 18, 'aliases' => []],
            ['name' => 'Morcon', 'category' => 'Ulam', 'serving' => '1 slice (~120g)', 'cal' => 280, 'pro' => 20, 'carb' => 10, 'fat' => 17, 'aliases' => ['beef roll']],
            ['name' => 'Embutido', 'category' => 'Ulam', 'serving' => '1 slice (~100g)', 'cal' => 260, 'pro' => 15, 'carb' => 12, 'fat' => 17, 'aliases' => ['filipino meatloaf']],
            ['name' => 'Tortang Giniling', 'category' => 'Ulam', 'serving' => '1 piece (~120g)', 'cal' => 220, 'pro' => 14, 'carb' => 6, 'fat' => 15, 'aliases' => ['ground meat omelet']],
            ['name' => 'Sinilihan', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 18, 'carb' => 8, 'fat' => 26, 'aliases' => ['bicol spicy pork']],
            ['name' => 'Adobong Kangkong', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 140, 'pro' => 5, 'carb' => 10, 'fat' => 9, 'aliases' => ['water spinach adobo']],
            ['name' => 'Adobong Sitaw', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 150, 'pro' => 5, 'carb' => 12, 'fat' => 9, 'aliases' => ['string beans adobo']],
            ['name' => 'Pork Kilawin', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 260, 'pro' => 22, 'carb' => 4, 'fat' => 17, 'aliases' => []],
            ['name' => 'Pinikpikan', 'category' => 'Ulam', 'serving' => '1 bowl (~300g)', 'cal' => 240, 'pro' => 22, 'carb' => 6, 'fat' => 14, 'aliases' => ['igorot chicken soup']],
            ['name' => 'Sisig na Manok', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 350, 'pro' => 24, 'carb' => 8, 'fat' => 24, 'aliases' => ['chicken sisig']],
            ['name' => 'Sisig na Tuna', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 26, 'carb' => 6, 'fat' => 16, 'aliases' => ['tuna sisig']],
            ['name' => 'Pork Adobo Flakes', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 320, 'pro' => 22, 'carb' => 6, 'fat' => 22, 'aliases' => []],
            ['name' => 'Beef Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 24, 'carb' => 6, 'fat' => 24, 'aliases' => []],
            ['name' => 'Chicken Adobo Flakes', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 24, 'carb' => 6, 'fat' => 17, 'aliases' => []],
            ['name' => 'Longganisa Hamonado', 'category' => 'Ulam', 'serving' => '2 links (~70g)', 'cal' => 240, 'pro' => 10, 'carb' => 10, 'fat' => 17, 'aliases' => []],
            ['name' => 'Vigan Longganisa', 'category' => 'Ulam', 'serving' => '2 links (~70g)', 'cal' => 230, 'pro' => 11, 'carb' => 6, 'fat' => 17, 'aliases' => []],
            ['name' => 'Lucban Longganisa', 'category' => 'Ulam', 'serving' => '2 links (~70g)', 'cal' => 220, 'pro' => 10, 'carb' => 6, 'fat' => 16, 'aliases' => []],
            ['name' => 'Cebu Chorizo', 'category' => 'Ulam', 'serving' => '2 links (~70g)', 'cal' => 250, 'pro' => 11, 'carb' => 8, 'fat' => 18, 'aliases' => []],
            ['name' => 'Beef Pochero', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 320, 'pro' => 22, 'carb' => 16, 'fat' => 18, 'aliases' => []],
            ['name' => 'Pork Pochero', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 310, 'pro' => 20, 'carb' => 16, 'fat' => 18, 'aliases' => []],
            ['name' => 'Callos', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 20, 'carb' => 10, 'fat' => 20, 'aliases' => ['ox tripe stew']],
            ['name' => 'Kaldereta na Kambing', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 330, 'pro' => 24, 'carb' => 12, 'fat' => 20, 'aliases' => ['goat caldereta']],
            ['name' => 'Adobong Manok sa Gata', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 360, 'pro' => 24, 'carb' => 6, 'fat' => 27, 'aliases' => ['chicken adobo in coconut milk']],
            ['name' => 'Chicken Binakol', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 240, 'pro' => 22, 'carb' => 8, 'fat' => 13, 'aliases' => ['chicken in coconut water']],
            ['name' => 'Beef Kansi', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 300, 'pro' => 22, 'carb' => 8, 'fat' => 19, 'aliases' => ['bacolod beef marrow soup']],
            ['name' => 'KBL', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 280, 'pro' => 18, 'carb' => 14, 'fat' => 16, 'aliases' => ['kadyos baboy langka']],
            ['name' => 'Chicken Curry', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 20, 'carb' => 10, 'fat' => 19, 'aliases' => ['filipino style chicken curry']],
            ['name' => 'Beef Curry', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 320, 'pro' => 22, 'carb' => 10, 'fat' => 21, 'aliases' => []],
            ['name' => 'Sinampalukang Manok', 'category' => 'Ulam', 'serving' => '1 bowl (~350g)', 'cal' => 210, 'pro' => 20, 'carb' => 8, 'fat' => 10, 'aliases' => ['chicken tamarind soup']],
            // --- Vegetable ---
            ['name' => 'Ginataang Sitaw at Kalabasa', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 190, 'pro' => 6, 'carb' => 14, 'fat' => 13, 'aliases' => []],
            ['name' => 'Dinengdeng', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 150, 'pro' => 8, 'carb' => 14, 'fat' => 6, 'aliases' => ['ilocano vegetable stew']],
            // --- Ulam ---
            ['name' => 'Tokwa at Baboy', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 260, 'pro' => 16, 'carb' => 8, 'fat' => 18, 'aliases' => ['tokwat baboy']],
            // --- Soup ---
            ['name' => 'Papaitan', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 230, 'pro' => 20, 'carb' => 4, 'fat' => 14, 'aliases' => ['goat innards soup']],
            // --- Seafood ---
            ['name' => 'Ginataang Isda', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 250, 'pro' => 20, 'carb' => 6, 'fat' => 17, 'aliases' => ['fish in coconut milk']],
            // --- Soup ---
            ['name' => 'Sinigang na Bangus', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 200, 'pro' => 18, 'carb' => 10, 'fat' => 9, 'aliases' => []],
            ['name' => 'Sinigang na Corned Beef', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 260, 'pro' => 18, 'carb' => 12, 'fat' => 15, 'aliases' => []],
            // --- Seafood ---
            ['name' => 'Paksiw na Bangus', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 220, 'pro' => 20, 'carb' => 6, 'fat' => 12, 'aliases' => []],
            ['name' => 'Paksiw na Isda', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 200, 'pro' => 18, 'carb' => 6, 'fat' => 10, 'aliases' => ['fish paksiw']],
            ['name' => 'Rellenong Bangus', 'category' => 'Seafood', 'serving' => '1 piece (~200g)', 'cal' => 300, 'pro' => 26, 'carb' => 8, 'fat' => 17, 'aliases' => ['stuffed milkfish']],
            ['name' => 'Fried Bangus', 'category' => 'Seafood', 'serving' => '1 piece (~150g)', 'cal' => 280, 'pro' => 24, 'carb' => 0, 'fat' => 20, 'aliases' => ['fried milkfish']],
            ['name' => 'Fried Tilapia', 'category' => 'Seafood', 'serving' => '1 piece (~150g)', 'cal' => 220, 'pro' => 24, 'carb' => 0, 'fat' => 12, 'aliases' => []],
            // --- Soup ---
            ['name' => 'Sinigang na Tilapia', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 190, 'pro' => 18, 'carb' => 9, 'fat' => 8, 'aliases' => []],
            // --- Seafood ---
            ['name' => 'Ginataang Tilapia', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 20, 'carb' => 6, 'fat' => 20, 'aliases' => []],
            ['name' => 'Ginataang Hipon', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 260, 'pro' => 20, 'carb' => 6, 'fat' => 18, 'aliases' => ['shrimp in coconut milk']],
            ['name' => 'Camaron Rebosado', 'category' => 'Seafood', 'serving' => '6 pieces (~180g)', 'cal' => 280, 'pro' => 16, 'carb' => 20, 'fat' => 16, 'aliases' => ['battered fried shrimp']],
            ['name' => 'Halabos na Hipon', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 200, 'pro' => 22, 'carb' => 4, 'fat' => 10, 'aliases' => ['sauteed shrimp']],
            ['name' => 'Ginataang Pusit', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 260, 'pro' => 18, 'carb' => 6, 'fat' => 19, 'aliases' => ['squid in coconut milk']],
            ['name' => 'Calamares', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 300, 'pro' => 18, 'carb' => 20, 'fat' => 17, 'aliases' => ['fried squid rings']],
            ['name' => 'Kinilaw na Tanigue', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 200, 'pro' => 24, 'carb' => 6, 'fat' => 8, 'aliases' => ['spanish mackerel ceviche']],
            ['name' => 'Kinilaw na Tuna', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 190, 'pro' => 26, 'carb' => 4, 'fat' => 7, 'aliases' => ['tuna kinilaw']],
            ['name' => 'Inihaw na Panga ng Tuna', 'category' => 'Seafood', 'serving' => '1 piece (~200g)', 'cal' => 320, 'pro' => 30, 'carb' => 0, 'fat' => 22, 'aliases' => ['grilled tuna jaw']],
            ['name' => 'Inihaw na Bangus', 'category' => 'Seafood', 'serving' => '1 piece (~150g)', 'cal' => 240, 'pro' => 24, 'carb' => 0, 'fat' => 15, 'aliases' => ['grilled milkfish']],
            ['name' => 'Sinaing na Tulingan', 'category' => 'Seafood', 'serving' => '1 piece (~200g)', 'cal' => 220, 'pro' => 26, 'carb' => 2, 'fat' => 11, 'aliases' => ['bicol braised tuna']],
            ['name' => 'Ginataang Alimasag', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 20, 'carb' => 6, 'fat' => 22, 'aliases' => ['crab in coconut milk']],
            ['name' => 'Chili Crab', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 320, 'pro' => 22, 'carb' => 10, 'fat' => 20, 'aliases' => ['filipino style chili crab']],
            ['name' => 'Curacha sa Gata', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 320, 'pro' => 20, 'carb' => 6, 'fat' => 24, 'aliases' => ['spanner crab in coconut milk']],
            ['name' => 'Pinangat na Isda', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 240, 'pro' => 18, 'carb' => 8, 'fat' => 15, 'aliases' => ['bicol fish stew']],
            ['name' => 'Ginataang Kuhol', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 220, 'pro' => 12, 'carb' => 8, 'fat' => 16, 'aliases' => ['snails in coconut milk']],
            // --- Ulam ---
            ['name' => 'Ampalaya con Carne', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 220, 'pro' => 16, 'carb' => 10, 'fat' => 12, 'aliases' => ['bitter gourd with beef']],
            // --- Soup ---
            ['name' => 'Fish Sinigang sa Miso', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 210, 'pro' => 18, 'carb' => 10, 'fat' => 9, 'aliases' => []],
            ['name' => 'Tinolang Isda', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 180, 'pro' => 18, 'carb' => 8, 'fat' => 7, 'aliases' => ['fish tinola']],
            ['name' => 'Tinowa', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 180, 'pro' => 18, 'carb' => 6, 'fat' => 8, 'aliases' => ['visayan fish ginger soup']],
            // --- Seafood ---
            ['name' => 'Adobong Kuhol', 'category' => 'Seafood', 'serving' => '1 cup (~200g)', 'cal' => 210, 'pro' => 12, 'carb' => 8, 'fat' => 14, 'aliases' => ['snail adobo']],
            ['name' => 'Ginataang Bilo-Bilo na may Isda', 'category' => 'Seafood', 'serving' => '1 cup (~245g)', 'cal' => 260, 'pro' => 18, 'carb' => 8, 'fat' => 17, 'aliases' => []],
            // --- Vegetable ---
            ['name' => 'Chopsuey', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 180, 'pro' => 8, 'carb' => 14, 'fat' => 10, 'aliases' => ['mixed vegetable stir-fry']],
            // --- Snack ---
            ['name' => 'Lumpiang Gulay', 'category' => 'Snack', 'serving' => '4 pieces', 'cal' => 200, 'pro' => 6, 'carb' => 22, 'fat' => 10, 'aliases' => ['vegetable spring rolls']],
            // --- Vegetable ---
            ['name' => 'Ensaladang Talong', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 90, 'pro' => 3, 'carb' => 10, 'fat' => 5, 'aliases' => ['grilled eggplant salad']],
            ['name' => 'Ginisang Ampalaya', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 150, 'pro' => 7, 'carb' => 10, 'fat' => 9, 'aliases' => ['sauteed bitter gourd']],
            ['name' => 'Ginisang Repolyo', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 120, 'pro' => 5, 'carb' => 10, 'fat' => 7, 'aliases' => ['sauteed cabbage']],
            ['name' => 'Ginisang Upo', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 130, 'pro' => 5, 'carb' => 10, 'fat' => 8, 'aliases' => ['sauteed bottle gourd']],
            ['name' => 'Ginisang Sayote', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 120, 'pro' => 4, 'carb' => 10, 'fat' => 7, 'aliases' => ['sauteed chayote']],
            ['name' => 'Ginisang Kalabasa at Sitaw', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 150, 'pro' => 6, 'carb' => 14, 'fat' => 8, 'aliases' => []],
            ['name' => 'Ginataang Langka', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 220, 'pro' => 4, 'carb' => 20, 'fat' => 15, 'aliases' => ['jackfruit in coconut milk']],
            ['name' => 'Ginataang Gulay', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 200, 'pro' => 6, 'carb' => 16, 'fat' => 14, 'aliases' => ['mixed vegetables in coconut milk']],
            // --- Soup ---
            ['name' => 'Utan Bisaya', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 130, 'pro' => 6, 'carb' => 14, 'fat' => 6, 'aliases' => ['visayan vegetable soup']],
            // --- Vegetable ---
            ['name' => 'Ensaladang Ampalaya', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 80, 'pro' => 3, 'carb' => 10, 'fat' => 3, 'aliases' => []],
            ['name' => 'Ensaladang Kamatis', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 60, 'pro' => 2, 'carb' => 8, 'fat' => 2, 'aliases' => ['tomato salad']],
            ['name' => 'Green Mango Salad', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 100, 'pro' => 1, 'carb' => 22, 'fat' => 1, 'aliases' => []],
            // --- Soup ---
            ['name' => 'Sinigang na Gulay', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 120, 'pro' => 4, 'carb' => 16, 'fat' => 5, 'aliases' => ['vegetable sinigang']],
            // --- Vegetable ---
            ['name' => 'Ginataang Puso ng Saging', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 190, 'pro' => 5, 'carb' => 12, 'fat' => 14, 'aliases' => ['banana blossom in coconut milk']],
            ['name' => 'Pako Salad', 'category' => 'Vegetable', 'serving' => '1 cup (~150g)', 'cal' => 70, 'pro' => 2, 'carb' => 9, 'fat' => 3, 'aliases' => ['fern salad']],
            ['name' => 'Ginisang Kangkong', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 100, 'pro' => 4, 'carb' => 8, 'fat' => 6, 'aliases' => ['sauteed water spinach']],
            ['name' => 'Ginisang Pechay', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 90, 'pro' => 4, 'carb' => 6, 'fat' => 6, 'aliases' => ['sauteed bok choy']],
            // --- Soup ---
            ['name' => 'Bulanglang', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 130, 'pro' => 5, 'carb' => 14, 'fat' => 6, 'aliases' => ['batangas vegetable soup']],
            ['name' => 'Molo Soup', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 220, 'pro' => 14, 'carb' => 20, 'fat' => 9, 'aliases' => ['pork dumpling soup']],
            ['name' => 'Sopas', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 240, 'pro' => 12, 'carb' => 26, 'fat' => 9, 'aliases' => ['filipino chicken macaroni soup']],
            // --- Vegetable ---
            ['name' => 'Ginisang Sitaw', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 110, 'pro' => 4, 'carb' => 10, 'fat' => 6, 'aliases' => ['sauteed string beans']],
            ['name' => 'Ginataang Sigarilyas', 'category' => 'Vegetable', 'serving' => '1 cup (~200g)', 'cal' => 170, 'pro' => 5, 'carb' => 12, 'fat' => 12, 'aliases' => ['winged bean in coconut milk']],
            // --- Rice ---
            ['name' => 'Brown Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 215, 'pro' => 5, 'carb' => 45, 'fat' => 1.8, 'aliases' => []],
            ['name' => 'Red Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 210, 'pro' => 5, 'carb' => 44, 'fat' => 1.5, 'aliases' => []],
            ['name' => 'Malagkit Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 230, 'pro' => 4, 'carb' => 50, 'fat' => 0.5, 'aliases' => ['glutinous rice']],
            ['name' => 'Java Rice', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 260, 'pro' => 4, 'carb' => 42, 'fat' => 9, 'aliases' => []],
            ['name' => 'Yang Chow Fried Rice', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 300, 'pro' => 10, 'carb' => 42, 'fat' => 10, 'aliases' => []],
            ['name' => 'Bagoong Rice', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 280, 'pro' => 6, 'carb' => 40, 'fat' => 10, 'aliases' => ['shrimp paste fried rice']],
            ['name' => 'Tinapa Rice', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 290, 'pro' => 10, 'carb' => 40, 'fat' => 10, 'aliases' => ['smoked fish fried rice']],
            ['name' => 'Bacon Fried Rice', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 300, 'pro' => 8, 'carb' => 40, 'fat' => 12, 'aliases' => []],
            ['name' => 'Lugaw', 'category' => 'Rice', 'serving' => '1 bowl (~300g)', 'cal' => 180, 'pro' => 3, 'carb' => 38, 'fat' => 1, 'aliases' => ['plain rice porridge']],
            ['name' => 'Black Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 220, 'pro' => 5, 'carb' => 46, 'fat' => 1.5, 'aliases' => ['pirurutong']],
            // --- Noodles ---
            ['name' => 'Pancit Malabon', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 330, 'pro' => 14, 'carb' => 40, 'fat' => 13, 'aliases' => []],
            ['name' => 'Pancit Habhab', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 8, 'carb' => 42, 'fat' => 8, 'aliases' => []],
            ['name' => 'Lomi', 'category' => 'Noodles', 'serving' => '1 bowl (~350g)', 'cal' => 380, 'pro' => 16, 'carb' => 45, 'fat' => 15, 'aliases' => []],
            ['name' => 'Mami', 'category' => 'Noodles', 'serving' => '1 bowl (~350g)', 'cal' => 320, 'pro' => 18, 'carb' => 38, 'fat' => 10, 'aliases' => ['beef noodle soup']],
            ['name' => 'Sotanghon Guisado', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 260, 'pro' => 10, 'carb' => 38, 'fat' => 8, 'aliases' => []],
            ['name' => 'Spaghetti Filipino Style', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 380, 'pro' => 12, 'carb' => 55, 'fat' => 12, 'aliases' => []],
            ['name' => 'Carbonara Filipino Style', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 420, 'pro' => 14, 'carb' => 45, 'fat' => 20, 'aliases' => []],
            ['name' => 'Batil-Patong', 'category' => 'Noodles', 'serving' => '1 bowl (~350g)', 'cal' => 350, 'pro' => 18, 'carb' => 40, 'fat' => 14, 'aliases' => ['tuguegarao noodles']],
            ['name' => 'Miki Bihon Guisado', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 300, 'pro' => 10, 'carb' => 40, 'fat' => 10, 'aliases' => []],
            ['name' => 'Pancit Bam-i', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 310, 'pro' => 12, 'carb' => 40, 'fat' => 11, 'aliases' => ['visayan mixed noodles']],
            // --- Breakfast ---
            ['name' => 'Tapsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 550, 'pro' => 30, 'carb' => 55, 'fat' => 22, 'aliases' => []],
            ['name' => 'Tocilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 580, 'pro' => 22, 'carb' => 60, 'fat' => 26, 'aliases' => []],
            ['name' => 'Longsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 560, 'pro' => 20, 'carb' => 55, 'fat' => 28, 'aliases' => []],
            ['name' => 'Bangsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 520, 'pro' => 32, 'carb' => 48, 'fat' => 24, 'aliases' => []],
            ['name' => 'Cornsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 540, 'pro' => 26, 'carb' => 50, 'fat' => 26, 'aliases' => []],
            ['name' => 'Hotsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 500, 'pro' => 18, 'carb' => 52, 'fat' => 24, 'aliases' => []],
            ['name' => 'Spamsilog', 'category' => 'Breakfast', 'serving' => '1 plate', 'cal' => 560, 'pro' => 18, 'carb' => 50, 'fat' => 32, 'aliases' => []],
            ['name' => 'Fried Egg', 'category' => 'Breakfast', 'serving' => '1 piece', 'cal' => 90, 'pro' => 6, 'carb' => 0.5, 'fat' => 7, 'aliases' => ['itlog na prito']],
            ['name' => 'Salted Egg', 'category' => 'Breakfast', 'serving' => '1 piece', 'cal' => 70, 'pro' => 6, 'carb' => 0.5, 'fat' => 5, 'aliases' => ['itlog na maalat']],
            ['name' => 'Balut', 'category' => 'Breakfast', 'serving' => '1 piece', 'cal' => 190, 'pro' => 14, 'carb' => 4, 'fat' => 12, 'aliases' => []],
            ['name' => 'Penoy', 'category' => 'Breakfast', 'serving' => '1 piece', 'cal' => 130, 'pro' => 11, 'carb' => 1, 'fat' => 9, 'aliases' => []],
            ['name' => 'Kesong Puti', 'category' => 'Breakfast', 'serving' => '30 g', 'cal' => 90, 'pro' => 6, 'carb' => 1, 'fat' => 7, 'aliases' => ['white cheese']],
            ['name' => 'Suman', 'category' => 'Breakfast', 'serving' => '1 piece', 'cal' => 160, 'pro' => 2, 'carb' => 32, 'fat' => 3, 'aliases' => ['sticky rice cake']],
            ['name' => 'Puto Bumbong', 'category' => 'Breakfast', 'serving' => '1 serving', 'cal' => 180, 'pro' => 3, 'carb' => 36, 'fat' => 3, 'aliases' => []],
            ['name' => 'Kalamay', 'category' => 'Breakfast', 'serving' => '1 slice', 'cal' => 190, 'pro' => 2, 'carb' => 38, 'fat' => 4, 'aliases' => []],
            // --- Snack ---
            ['name' => 'Tokneneng', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 280, 'pro' => 12, 'carb' => 20, 'fat' => 17, 'aliases' => []],
            ['name' => 'Squidball', 'category' => 'Snack', 'serving' => '10 pieces', 'cal' => 240, 'pro' => 10, 'carb' => 22, 'fat' => 12, 'aliases' => []],
            ['name' => 'Cheese Sticks', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 220, 'pro' => 6, 'carb' => 24, 'fat' => 11, 'aliases' => []],
            ['name' => 'Empanada', 'category' => 'Snack', 'serving' => '1 piece', 'cal' => 250, 'pro' => 8, 'carb' => 28, 'fat' => 12, 'aliases' => ['filipino meat pie']],
            ['name' => 'Siomai', 'category' => 'Snack', 'serving' => '4 pieces', 'cal' => 220, 'pro' => 10, 'carb' => 18, 'fat' => 12, 'aliases' => ['filipino steamed dumpling']],
            ['name' => 'Siopao Asado', 'category' => 'Snack', 'serving' => '1 piece', 'cal' => 300, 'pro' => 12, 'carb' => 45, 'fat' => 8, 'aliases' => []],
            ['name' => 'Siopao Bola-Bola', 'category' => 'Snack', 'serving' => '1 piece', 'cal' => 320, 'pro' => 13, 'carb' => 44, 'fat' => 10, 'aliases' => []],
            ['name' => 'Maruya', 'category' => 'Snack', 'serving' => '2 pieces', 'cal' => 220, 'pro' => 2, 'carb' => 34, 'fat' => 9, 'aliases' => ['banana fritters']],
            ['name' => 'Binatog', 'category' => 'Snack', 'serving' => '1 cup', 'cal' => 200, 'pro' => 4, 'carb' => 38, 'fat' => 5, 'aliases' => ['boiled corn with coconut']],
            ['name' => 'Ukoy', 'category' => 'Snack', 'serving' => '2 pieces', 'cal' => 240, 'pro' => 8, 'carb' => 26, 'fat' => 12, 'aliases' => ['shrimp fritters']],
            ['name' => 'Chicharon Bulaklak', 'category' => 'Snack', 'serving' => '30 g', 'cal' => 200, 'pro' => 10, 'carb' => 0, 'fat' => 18, 'aliases' => []],
            ['name' => 'Chicharon Manok', 'category' => 'Snack', 'serving' => '30 g', 'cal' => 190, 'pro' => 10, 'carb' => 4, 'fat' => 15, 'aliases' => ['chicken skin chips']],
            ['name' => 'Dried Mango', 'category' => 'Snack', 'serving' => '30 g', 'cal' => 100, 'pro' => 0.5, 'carb' => 24, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Otap', 'category' => 'Snack', 'serving' => '2 pieces', 'cal' => 160, 'pro' => 2, 'carb' => 20, 'fat' => 8, 'aliases' => ['cebu puff pastry']],
            ['name' => 'Rosquillos', 'category' => 'Snack', 'serving' => '4 pieces', 'cal' => 180, 'pro' => 3, 'carb' => 26, 'fat' => 7, 'aliases' => ['ring-shaped cookies']],
            ['name' => 'Pilipit', 'category' => 'Snack', 'serving' => '3 pieces', 'cal' => 200, 'pro' => 3, 'carb' => 28, 'fat' => 9, 'aliases' => ['twisted fried dough']],
            ['name' => 'Barquillos', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 150, 'pro' => 2, 'carb' => 24, 'fat' => 5, 'aliases' => ['rolled wafer']],
            ['name' => 'Polvoron', 'category' => 'Snack', 'serving' => '3 pieces', 'cal' => 210, 'pro' => 3, 'carb' => 26, 'fat' => 10, 'aliases' => []],
            ['name' => 'Yema', 'category' => 'Snack', 'serving' => '4 pieces', 'cal' => 200, 'pro' => 3, 'carb' => 32, 'fat' => 7, 'aliases' => ['custard candy']],
            ['name' => 'Kikiam', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 230, 'pro' => 9, 'carb' => 18, 'fat' => 14, 'aliases' => []],
            ['name' => 'Ginataang Mais Snack', 'category' => 'Snack', 'serving' => '1 cup', 'cal' => 200, 'pro' => 3, 'carb' => 34, 'fat' => 6, 'aliases' => []],
            // --- Dessert ---
            ['name' => 'Cassava Cake', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 280, 'pro' => 4, 'carb' => 42, 'fat' => 11, 'aliases' => []],
            ['name' => 'Maja Blanca', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 220, 'pro' => 3, 'carb' => 34, 'fat' => 8, 'aliases' => []],
            ['name' => 'Ginataang Bilo-Bilo', 'category' => 'Dessert', 'serving' => '1 bowl', 'cal' => 260, 'pro' => 4, 'carb' => 42, 'fat' => 10, 'aliases' => []],
            ['name' => 'Tibok-Tibok', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 200, 'pro' => 3, 'carb' => 26, 'fat' => 9, 'aliases' => []],
            ['name' => 'Pastillas de Leche', 'category' => 'Dessert', 'serving' => '4 pieces', 'cal' => 180, 'pro' => 3, 'carb' => 30, 'fat' => 5, 'aliases' => []],
            ['name' => 'Sans Rival', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 380, 'pro' => 5, 'carb' => 30, 'fat' => 26, 'aliases' => []],
            ['name' => 'Palitaw', 'category' => 'Dessert', 'serving' => '4 pieces', 'cal' => 180, 'pro' => 3, 'carb' => 32, 'fat' => 5, 'aliases' => []],
            ['name' => 'Biko', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 240, 'pro' => 3, 'carb' => 42, 'fat' => 7, 'aliases' => []],
            ['name' => 'Espasol', 'category' => 'Dessert', 'serving' => '2 pieces', 'cal' => 200, 'pro' => 2, 'carb' => 34, 'fat' => 6, 'aliases' => []],
            ['name' => 'Tikoy', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 210, 'pro' => 2, 'carb' => 46, 'fat' => 2, 'aliases' => ['chinese-filipino rice cake']],
            ['name' => 'Buko Salad', 'category' => 'Dessert', 'serving' => '1 cup', 'cal' => 220, 'pro' => 3, 'carb' => 30, 'fat' => 10, 'aliases' => []],
            ['name' => 'Fruit Salad Filipino Style', 'category' => 'Dessert', 'serving' => '1 cup', 'cal' => 250, 'pro' => 3, 'carb' => 35, 'fat' => 11, 'aliases' => []],
            ['name' => 'Ube Halaya', 'category' => 'Dessert', 'serving' => '1/2 cup', 'cal' => 220, 'pro' => 2, 'carb' => 40, 'fat' => 6, 'aliases' => ['ube jam']],
            ['name' => 'Ube Ice Cream', 'category' => 'Dessert', 'serving' => '1 scoop', 'cal' => 180, 'pro' => 3, 'carb' => 24, 'fat' => 8, 'aliases' => []],
            ['name' => 'Sorbetes', 'category' => 'Dessert', 'serving' => '1 scoop', 'cal' => 160, 'pro' => 2, 'carb' => 22, 'fat' => 7, 'aliases' => ['filipino ice cream']],
            ['name' => 'Halayang Kalabasa', 'category' => 'Dessert', 'serving' => '1/2 cup', 'cal' => 200, 'pro' => 2, 'carb' => 38, 'fat' => 5, 'aliases' => ['squash jam']],
            ['name' => 'Minatamis na Saging', 'category' => 'Dessert', 'serving' => '1 cup', 'cal' => 220, 'pro' => 1, 'carb' => 50, 'fat' => 1, 'aliases' => ['sweetened banana']],
            ['name' => 'Ginataang Mais', 'category' => 'Dessert', 'serving' => '1 bowl', 'cal' => 220, 'pro' => 4, 'carb' => 36, 'fat' => 8, 'aliases' => ['corn in coconut milk']],
            ['name' => 'Bukayo', 'category' => 'Dessert', 'serving' => '4 pieces', 'cal' => 180, 'pro' => 1, 'carb' => 26, 'fat' => 8, 'aliases' => ['sweetened coconut candy']],
            ['name' => 'Puto Seco', 'category' => 'Dessert', 'serving' => '4 pieces', 'cal' => 190, 'pro' => 3, 'carb' => 28, 'fat' => 7, 'aliases' => []],
            ['name' => 'Ube Puto', 'category' => 'Dessert', 'serving' => '3 pieces', 'cal' => 170, 'pro' => 3, 'carb' => 32, 'fat' => 3, 'aliases' => []],
            ['name' => 'Latik', 'category' => 'Dessert', 'serving' => '2 tbsp', 'cal' => 90, 'pro' => 1, 'carb' => 4, 'fat' => 8, 'aliases' => ['coconut curd topping']],
            ['name' => 'Bibingkang Malagkit', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 230, 'pro' => 3, 'carb' => 40, 'fat' => 6, 'aliases' => []],
            // --- Beverage ---
            ['name' => 'Buko Juice', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 90, 'pro' => 2, 'carb' => 20, 'fat' => 0.5, 'aliases' => ['coconut water']],
            ['name' => 'Mango Shake', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 220, 'pro' => 3, 'carb' => 45, 'fat' => 4, 'aliases' => []],
            ['name' => 'Avocado Shake', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 260, 'pro' => 4, 'carb' => 32, 'fat' => 13, 'aliases' => []],
            ['name' => 'Melon Juice', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 120, 'pro' => 1, 'carb' => 28, 'fat' => 0.3, 'aliases' => []],
            ['name' => 'Four Seasons Juice', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 140, 'pro' => 0.5, 'carb' => 34, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Kapeng Barako', 'category' => 'Beverage', 'serving' => '1 cup', 'cal' => 5, 'pro' => 0.3, 'carb' => 1, 'fat' => 0, 'aliases' => ['black coffee']],
            ['name' => 'Salabat', 'category' => 'Beverage', 'serving' => '1 cup', 'cal' => 40, 'pro' => 0, 'carb' => 10, 'fat' => 0, 'aliases' => ['ginger tea']],
            ['name' => 'Tsokolate', 'category' => 'Beverage', 'serving' => '1 cup', 'cal' => 180, 'pro' => 4, 'carb' => 24, 'fat' => 8, 'aliases' => ['filipino hot chocolate', 'sikwate']],
            ['name' => 'Iced Tea Filipino Style', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 90, 'pro' => 0, 'carb' => 22, 'fat' => 0, 'aliases' => []],
            ['name' => 'Basi', 'category' => 'Beverage', 'serving' => '1 glass (~200ml)', 'cal' => 150, 'pro' => 0, 'carb' => 18, 'fat' => 0, 'aliases' => ['sugarcane wine']],
            ['name' => 'Tapuy', 'category' => 'Beverage', 'serving' => '1 glass (~200ml)', 'cal' => 160, 'pro' => 0, 'carb' => 20, 'fat' => 0, 'aliases' => ['rice wine']],
            ['name' => 'Local Beer Lager', 'category' => 'Beverage', 'serving' => '1 bottle (~320ml)', 'cal' => 130, 'pro' => 1, 'carb' => 10, 'fat' => 0, 'aliases' => []],
            ['name' => 'Pineapple Juice Fresh', 'category' => 'Beverage', 'serving' => '1 glass (~350ml)', 'cal' => 130, 'pro' => 1, 'carb' => 32, 'fat' => 0.3, 'aliases' => []],
            // --- Fruit ---
            ['name' => 'Mango Ripe', 'category' => 'Fruit', 'serving' => '1 cup, sliced', 'cal' => 100, 'pro' => 1.4, 'carb' => 25, 'fat' => 0.6, 'aliases' => []],
            ['name' => 'Banana Lakatan', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 105, 'pro' => 1.3, 'carb' => 27, 'fat' => 0.4, 'aliases' => []],
            ['name' => 'Banana Saba Boiled', 'category' => 'Fruit', 'serving' => '1 piece', 'cal' => 120, 'pro' => 1.2, 'carb' => 31, 'fat' => 0.3, 'aliases' => []],
            ['name' => 'Banana Latundan', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 90, 'pro' => 1, 'carb' => 23, 'fat' => 0.3, 'aliases' => []],
            ['name' => 'Pineapple', 'category' => 'Fruit', 'serving' => '1 cup, sliced', 'cal' => 82, 'pro' => 0.9, 'carb' => 22, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Papaya Ripe', 'category' => 'Fruit', 'serving' => '1 cup, sliced', 'cal' => 62, 'pro' => 0.9, 'carb' => 16, 'fat' => 0.4, 'aliases' => []],
            ['name' => 'Guava', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 37, 'pro' => 1.4, 'carb' => 8, 'fat' => 0.5, 'aliases' => ['bayabas']],
            ['name' => 'Calamansi', 'category' => 'Fruit', 'serving' => '1 piece', 'cal' => 4, 'pro' => 0.1, 'carb' => 1, 'fat' => 0, 'aliases' => []],
            ['name' => 'Dalandan', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 60, 'pro' => 1.2, 'carb' => 15, 'fat' => 0.2, 'aliases' => ['local orange']],
            ['name' => 'Rambutan', 'category' => 'Fruit', 'serving' => '10 pieces', 'cal' => 75, 'pro' => 0.9, 'carb' => 20, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Lanzones', 'category' => 'Fruit', 'serving' => '10 pieces', 'cal' => 70, 'pro' => 0.7, 'carb' => 18, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Durian', 'category' => 'Fruit', 'serving' => '1 seed (~50g)', 'cal' => 90, 'pro' => 1.5, 'carb' => 15, 'fat' => 3, 'aliases' => []],
            ['name' => 'Jackfruit Ripe', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 155, 'pro' => 2.8, 'carb' => 38, 'fat' => 0.5, 'aliases' => ['langka']],
            ['name' => 'Watermelon', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 46, 'pro' => 0.9, 'carb' => 12, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Melon Honeydew', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 61, 'pro' => 0.9, 'carb' => 16, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Avocado', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 240, 'pro' => 3, 'carb' => 13, 'fat' => 22, 'aliases' => []],
            ['name' => 'Star Apple', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 65, 'pro' => 1, 'carb' => 14, 'fat' => 1, 'aliases' => ['kaimito']],
            ['name' => 'Santol', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 60, 'pro' => 0.5, 'carb' => 15, 'fat' => 0.3, 'aliases' => []],
            ['name' => 'Chico', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 90, 'pro' => 0.5, 'carb' => 22, 'fat' => 1.1, 'aliases' => ['sapodilla']],
            ['name' => 'Atis', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 100, 'pro' => 2, 'carb' => 25, 'fat' => 0.6, 'aliases' => ['sugar apple']],
            ['name' => 'Guyabano', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 137, 'pro' => 2, 'carb' => 35, 'fat' => 0.6, 'aliases' => ['soursop']],
            ['name' => 'Sinigwelas', 'category' => 'Fruit', 'serving' => '10 pieces', 'cal' => 60, 'pro' => 0.5, 'carb' => 15, 'fat' => 0.2, 'aliases' => ['spanish plum']],
            ['name' => 'Duhat', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 75, 'pro' => 1, 'carb' => 18, 'fat' => 0.3, 'aliases' => ['java plum']],
            ['name' => 'Sampalok Raw', 'category' => 'Fruit', 'serving' => '10 pieces', 'cal' => 70, 'pro' => 0.8, 'carb' => 18, 'fat' => 0.2, 'aliases' => ['tamarind']],
            ['name' => 'Suha', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 72, 'pro' => 1.4, 'carb' => 18, 'fat' => 0.1, 'aliases' => ['pomelo']],
            ['name' => 'Kamias', 'category' => 'Fruit', 'serving' => '10 pieces', 'cal' => 15, 'pro' => 0.3, 'carb' => 3, 'fat' => 0.1, 'aliases' => ['bilimbi']],
            ['name' => 'Green Mango', 'category' => 'Fruit', 'serving' => '1 cup, sliced', 'cal' => 60, 'pro' => 0.6, 'carb' => 15, 'fat' => 0.3, 'aliases' => ['unripe mango']],
            ['name' => 'Macopa', 'category' => 'Fruit', 'serving' => '1 cup', 'cal' => 40, 'pro' => 0.4, 'carb' => 10, 'fat' => 0.2, 'aliases' => ['java apple']],
            ['name' => 'Passion Fruit Local', 'category' => 'Fruit', 'serving' => '1 medium', 'cal' => 17, 'pro' => 0.4, 'carb' => 4, 'fat' => 0.1, 'aliases' => []],
            // --- Vegetable ---
            ['name' => 'Kangkong Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 20, 'pro' => 2, 'carb' => 3, 'fat' => 0.2, 'aliases' => ['water spinach']],
            ['name' => 'Talong Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 25, 'pro' => 1, 'carb' => 6, 'fat' => 0.2, 'aliases' => ['eggplant']],
            ['name' => 'Ampalaya Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 20, 'pro' => 1, 'carb' => 4, 'fat' => 0.2, 'aliases' => ['bitter gourd']],
            ['name' => 'Sitaw Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 35, 'pro' => 2, 'carb' => 7, 'fat' => 0.2, 'aliases' => ['string beans']],
            ['name' => 'Okra', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 33, 'pro' => 2, 'carb' => 7, 'fat' => 0.2, 'aliases' => []],
            ['name' => 'Kalabasa Raw', 'category' => 'Vegetable', 'serving' => '1 cup, cubed', 'cal' => 45, 'pro' => 1.8, 'carb' => 12, 'fat' => 0.2, 'aliases' => ['squash']],
            ['name' => 'Sayote Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 25, 'pro' => 1, 'carb' => 6, 'fat' => 0.1, 'aliases' => ['chayote']],
            ['name' => 'Upo Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 20, 'pro' => 1, 'carb' => 5, 'fat' => 0.1, 'aliases' => ['bottle gourd']],
            ['name' => 'Repolyo Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 22, 'pro' => 1, 'carb' => 5, 'fat' => 0.1, 'aliases' => ['cabbage']],
            ['name' => 'Pechay Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 13, 'pro' => 1.5, 'carb' => 2, 'fat' => 0.2, 'aliases' => ['bok choy']],
            ['name' => 'Malunggay Leaves', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 65, 'pro' => 6, 'carb' => 12, 'fat' => 1.5, 'aliases' => ['moringa']],
            ['name' => 'Camote Tops', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 35, 'pro' => 3, 'carb' => 6, 'fat' => 0.5, 'aliases' => ['sweet potato leaves']],
            ['name' => 'Labanos', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 19, 'pro' => 0.8, 'carb' => 4, 'fat' => 0.1, 'aliases' => ['radish']],
            ['name' => 'Sibuyas Raw', 'category' => 'Vegetable', 'serving' => '1 cup, chopped', 'cal' => 64, 'pro' => 1.8, 'carb' => 15, 'fat' => 0.2, 'aliases' => ['onion']],
            ['name' => 'Bawang', 'category' => 'Vegetable', 'serving' => '10 cloves', 'cal' => 45, 'pro' => 2, 'carb' => 10, 'fat' => 0.2, 'aliases' => ['garlic']],
            ['name' => 'Kamatis Raw', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 32, 'pro' => 1.6, 'carb' => 7, 'fat' => 0.4, 'aliases' => ['tomato']],
            ['name' => 'Luya', 'category' => 'Vegetable', 'serving' => '1 tbsp', 'cal' => 5, 'pro' => 0.1, 'carb' => 1, 'fat' => 0, 'aliases' => ['ginger']],
            ['name' => 'Sili Raw', 'category' => 'Vegetable', 'serving' => '5 pieces', 'cal' => 20, 'pro' => 1, 'carb' => 4, 'fat' => 0.2, 'aliases' => ['chili pepper']],
            ['name' => 'Sibuyas Tagalog', 'category' => 'Vegetable', 'serving' => '1/2 cup', 'cal' => 35, 'pro' => 1, 'carb' => 8, 'fat' => 0.1, 'aliases' => ['shallots']],
            ['name' => 'Patola', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 20, 'pro' => 1, 'carb' => 4, 'fat' => 0.1, 'aliases' => ['sponge gourd']],
            ['name' => 'Alugbati', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 15, 'pro' => 1.5, 'carb' => 3, 'fat' => 0.2, 'aliases' => ['malabar spinach']],
            ['name' => 'Saluyot', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 30, 'pro' => 3, 'carb' => 5, 'fat' => 0.5, 'aliases' => ['jute leaves']],
            ['name' => 'Camote Boiled', 'category' => 'Vegetable', 'serving' => '1 medium', 'cal' => 115, 'pro' => 2, 'carb' => 27, 'fat' => 0.2, 'aliases' => ['sweet potato']],
            ['name' => 'Gabi Boiled', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 150, 'pro' => 1.5, 'carb' => 35, 'fat' => 0.1, 'aliases' => ['taro']],
            ['name' => 'Kamoteng Kahoy Boiled', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 170, 'pro' => 1.5, 'carb' => 40, 'fat' => 0.3, 'aliases' => ['cassava']],
            ['name' => 'Ubi Boiled', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 160, 'pro' => 2, 'carb' => 38, 'fat' => 0.2, 'aliases' => ['yam']],
            ['name' => 'Mais Boiled', 'category' => 'Vegetable', 'serving' => '1 ear', 'cal' => 100, 'pro' => 3, 'carb' => 22, 'fat' => 1.5, 'aliases' => ['corn']],
            ['name' => 'Munggo Boiled', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 210, 'pro' => 14, 'carb' => 38, 'fat' => 0.8, 'aliases' => ['mung beans']],
            ['name' => 'Toge', 'category' => 'Vegetable', 'serving' => '1 cup', 'cal' => 30, 'pro' => 3, 'carb' => 6, 'fat' => 0.2, 'aliases' => ['mung bean sprouts']],
            // --- Condiment ---
            ['name' => 'Patis', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 5, 'pro' => 1, 'carb' => 0, 'fat' => 0, 'aliases' => ['fish sauce']],
            ['name' => 'Toyo', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 10, 'pro' => 1, 'carb' => 1, 'fat' => 0, 'aliases' => ['soy sauce']],
            ['name' => 'Suka', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 3, 'pro' => 0, 'carb' => 0.1, 'fat' => 0, 'aliases' => ['vinegar']],
            ['name' => 'Bagoong Alamang', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 30, 'pro' => 3, 'carb' => 2, 'fat' => 1, 'aliases' => ['shrimp paste']],
            ['name' => 'Bagoong Isda', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 25, 'pro' => 3, 'carb' => 1, 'fat' => 1, 'aliases' => ['fermented fish paste']],
            ['name' => 'Banana Ketchup', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 20, 'pro' => 0, 'carb' => 5, 'fat' => 0, 'aliases' => []],
            ['name' => 'Toyomansi', 'category' => 'Condiment', 'serving' => '2 tbsp', 'cal' => 15, 'pro' => 1, 'carb' => 2, 'fat' => 0, 'aliases' => ['soy-calamansi dip']],
            ['name' => 'Atchara', 'category' => 'Condiment', 'serving' => '1/2 cup', 'cal' => 80, 'pro' => 1, 'carb' => 18, 'fat' => 0.5, 'aliases' => ['pickled papaya']],
            ['name' => 'Achuete Oil', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 60, 'pro' => 0, 'carb' => 0, 'fat' => 7, 'aliases' => ['annatto oil']],
            ['name' => 'Buro', 'category' => 'Condiment', 'serving' => '1/4 cup', 'cal' => 90, 'pro' => 2, 'carb' => 18, 'fat' => 0.5, 'aliases' => ['fermented rice']],
            ['name' => 'Kimchi Filipino Style', 'category' => 'Condiment', 'serving' => '1/2 cup', 'cal' => 25, 'pro' => 1, 'carb' => 5, 'fat' => 0.3, 'aliases' => []],
            ['name' => 'Coconut Vinegar', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 3, 'pro' => 0, 'carb' => 0.1, 'fat' => 0, 'aliases' => []],
            ['name' => 'Gata', 'category' => 'Condiment', 'serving' => '1 cup', 'cal' => 445, 'pro' => 5, 'carb' => 6, 'fat' => 48, 'aliases' => ['coconut milk']],
            ['name' => 'Coconut Cream', 'category' => 'Condiment', 'serving' => '1/4 cup', 'cal' => 220, 'pro' => 2, 'carb' => 3, 'fat' => 24, 'aliases' => ['kakang gata']],
            // --- Processed ---
            ['name' => 'Corned Beef Canned', 'category' => 'Processed', 'serving' => '1/2 cup', 'cal' => 240, 'pro' => 20, 'carb' => 2, 'fat' => 18, 'aliases' => []],
            ['name' => 'Luncheon Meat Canned', 'category' => 'Processed', 'serving' => '2 slices (~60g)', 'cal' => 180, 'pro' => 7, 'carb' => 2, 'fat' => 16, 'aliases' => []],
            ['name' => 'Sardines in Tomato Sauce', 'category' => 'Processed', 'serving' => '1 can (~155g)', 'cal' => 220, 'pro' => 20, 'carb' => 4, 'fat' => 14, 'aliases' => []],
            ['name' => 'Sardines in Oil', 'category' => 'Processed', 'serving' => '1 can (~155g)', 'cal' => 260, 'pro' => 22, 'carb' => 1, 'fat' => 18, 'aliases' => []],
            ['name' => 'Tuna Flakes in Oil', 'category' => 'Processed', 'serving' => '1/2 cup', 'cal' => 180, 'pro' => 22, 'carb' => 0, 'fat' => 10, 'aliases' => []],
            ['name' => 'Hotdog Boiled', 'category' => 'Processed', 'serving' => '2 pieces', 'cal' => 200, 'pro' => 8, 'carb' => 4, 'fat' => 16, 'aliases' => []],
            ['name' => 'Vienna Sausage', 'category' => 'Processed', 'serving' => '5 pieces', 'cal' => 220, 'pro' => 9, 'carb' => 3, 'fat' => 19, 'aliases' => []],
            ['name' => 'Meatloaf Canned', 'category' => 'Processed', 'serving' => '2 slices', 'cal' => 200, 'pro' => 8, 'carb' => 6, 'fat' => 16, 'aliases' => []],
            ['name' => 'Corned Tuna', 'category' => 'Processed', 'serving' => '1/2 cup', 'cal' => 160, 'pro' => 20, 'carb' => 3, 'fat' => 8, 'aliases' => []],
            ['name' => 'Instant Noodles Filipino', 'category' => 'Processed', 'serving' => '1 pack, cooked', 'cal' => 380, 'pro' => 8, 'carb' => 52, 'fat' => 15, 'aliases' => []],
            ['name' => 'Cheese Spread Filipino', 'category' => 'Processed', 'serving' => '2 tbsp', 'cal' => 90, 'pro' => 3, 'carb' => 3, 'fat' => 7, 'aliases' => []],
            ['name' => 'Powdered Milk Reconstituted', 'category' => 'Processed', 'serving' => '1 cup', 'cal' => 150, 'pro' => 8, 'carb' => 12, 'fat' => 8, 'aliases' => []],
            ['name' => 'Saltine Crackers', 'category' => 'Processed', 'serving' => '6 pieces', 'cal' => 120, 'pro' => 2, 'carb' => 20, 'fat' => 4, 'aliases' => []],
            ['name' => 'Instant Pancit Canton Dry', 'category' => 'Processed', 'serving' => '1 pack, cooked', 'cal' => 400, 'pro' => 8, 'carb' => 58, 'fat' => 15, 'aliases' => []],
            ['name' => 'Skinless Longganisa Packed', 'category' => 'Processed', 'serving' => '2 links', 'cal' => 200, 'pro' => 9, 'carb' => 8, 'fat' => 14, 'aliases' => []],
            // --- Fermented ---
            ['name' => 'Tuyo', 'category' => 'Fermented', 'serving' => '2 pieces', 'cal' => 150, 'pro' => 20, 'carb' => 0, 'fat' => 8, 'aliases' => ['dried salted fish']],
            ['name' => 'Daing na Isda', 'category' => 'Fermented', 'serving' => '100 g', 'cal' => 200, 'pro' => 30, 'carb' => 0, 'fat' => 8, 'aliases' => ['dried fish, generic']],
            // --- Condiment ---
            ['name' => 'Pinakurat', 'category' => 'Condiment', 'serving' => '1 tbsp', 'cal' => 5, 'pro' => 0, 'carb' => 1, 'fat' => 0, 'aliases' => ['spiced vinegar']],
            // --- Fermented ---
            ['name' => 'Burong Mustasa', 'category' => 'Fermented', 'serving' => '1/2 cup', 'cal' => 40, 'pro' => 2, 'carb' => 8, 'fat' => 0.2, 'aliases' => ['fermented mustard greens']],
            ['name' => 'Burong Talangka', 'category' => 'Fermented', 'serving' => '2 tbsp', 'cal' => 90, 'pro' => 4, 'carb' => 1, 'fat' => 8, 'aliases' => ['fermented crab fat paste']],
        ];

        foreach ($dishes as $d) {
            Food::updateOrCreate(
                ['name' => $d['name']],
                [
                    'name_normalized' => Str::of($d['name'])->lower()->ascii()->value(),
                    'aliases' => $d['aliases'],
                    'category' => $d['category'],
                    'serving_description' => $d['serving'],
                    'calories' => $d['cal'],
                    'protein' => $d['pro'],
                    'carbs' => $d['carb'],
                    'fat' => $d['fat'],
                    'source' => 'estimated',
                ]
            );
        }
    }
}
