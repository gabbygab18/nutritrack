<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * IMPORTANT: The macros below are ballpark estimates for typical serving
 * sizes, compiled for a quick starter dataset — they are NOT pulled
 * directly from the FNRI Philippine Food Composition Tables (PFCT).
 *
 * Before this ships to real users tracking their intake, cross-check each
 * entry against the official FNRI PFCT (https://i.fnri.dost.gov.ph/) or
 * another verified source, and flip `source` from 'estimated' to
 * 'FNRI PFCT' once confirmed. Treat this seeder as scaffolding, not a
 * nutrition-accurate dataset.
 */
class FilipinoFoodSeeder extends Seeder
{
    public function run(): void
    {
        $dishes = [
            ['name' => 'Chicken Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 25, 'carb' => 6, 'fat' => 18, 'aliases' => ['adobong manok']],
            ['name' => 'Pork Adobo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 350, 'pro' => 22, 'carb' => 6, 'fat' => 26, 'aliases' => ['adobong baboy']],
            ['name' => 'Sinigang na Baboy', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 250, 'pro' => 18, 'carb' => 10, 'fat' => 15, 'aliases' => ['pork sinigang']],
            ['name' => 'Sinigang na Hipon', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 180, 'pro' => 16, 'carb' => 10, 'fat' => 8, 'aliases' => ['shrimp sinigang']],
            ['name' => 'Pork Sisig', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 430, 'pro' => 25, 'carb' => 8, 'fat' => 33, 'aliases' => []],
            ['name' => 'Lechon Kawali', 'category' => 'Ulam', 'serving' => '100 g', 'cal' => 400, 'pro' => 22, 'carb' => 0, 'fat' => 34, 'aliases' => []],
            ['name' => 'Kare-Kare', 'category' => 'Ulam', 'serving' => '1 cup (~250g, no rice)', 'cal' => 380, 'pro' => 20, 'carb' => 15, 'fat' => 27, 'aliases' => []],
            ['name' => 'Bulalo', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 320, 'pro' => 28, 'carb' => 8, 'fat' => 20, 'aliases' => ['beef bulalo']],
            ['name' => 'Chicken Tinola', 'category' => 'Soup', 'serving' => '1 bowl (~350g)', 'cal' => 200, 'pro' => 22, 'carb' => 8, 'fat' => 8, 'aliases' => ['tinolang manok']],
            ['name' => 'Pork Menudo', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 18, 'carb' => 15, 'fat' => 16, 'aliases' => []],
            ['name' => 'Chicken Caldereta', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 300, 'pro' => 19, 'carb' => 13, 'fat' => 18, 'aliases' => ['kaldereta']],
            ['name' => 'Beef Caldereta', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 340, 'pro' => 22, 'carb' => 12, 'fat' => 22, 'aliases' => ['kaldereta']],
            ['name' => 'Bicol Express', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 350, 'pro' => 15, 'carb' => 8, 'fat' => 28, 'aliases' => []],
            ['name' => 'Laing', 'category' => 'Ulam', 'serving' => '1 cup (~200g)', 'cal' => 220, 'pro' => 6, 'carb' => 10, 'fat' => 18, 'aliases' => []],
            ['name' => 'Dinuguan', 'category' => 'Ulam', 'serving' => '1 cup (~245g)', 'cal' => 280, 'pro' => 18, 'carb' => 8, 'fat' => 20, 'aliases' => []],
            ['name' => 'Chicharon', 'category' => 'Snack', 'serving' => '30 g', 'cal' => 165, 'pro' => 14, 'carb' => 0, 'fat' => 12, 'aliases' => ['chicharon baboy']],
            ['name' => 'Pancit Canton', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 280, 'pro' => 10, 'carb' => 40, 'fat' => 9, 'aliases' => []],
            ['name' => 'Pancit Bihon', 'category' => 'Noodles', 'serving' => '1 cup (~200g)', 'cal' => 250, 'pro' => 8, 'carb' => 42, 'fat' => 6, 'aliases' => []],
            ['name' => 'Lumpiang Shanghai', 'category' => 'Snack', 'serving' => '5 pieces', 'cal' => 220, 'pro' => 9, 'carb' => 18, 'fat' => 12, 'aliases' => ['shanghai']],
            ['name' => 'Lumpiang Sariwa', 'category' => 'Snack', 'serving' => '2 pieces', 'cal' => 150, 'pro' => 5, 'carb' => 20, 'fat' => 6, 'aliases' => []],
            ['name' => 'Chicken Inasal', 'category' => 'Ulam', 'serving' => '1 piece (thigh-leg)', 'cal' => 300, 'pro' => 28, 'carb' => 3, 'fat' => 19, 'aliases' => ['inasal']],
            ['name' => 'Longganisa', 'category' => 'Breakfast', 'serving' => '2 links (~70g)', 'cal' => 220, 'pro' => 10, 'carb' => 8, 'fat' => 16, 'aliases' => []],
            ['name' => 'Beef Tapa', 'category' => 'Breakfast', 'serving' => '100 g', 'cal' => 250, 'pro' => 24, 'carb' => 4, 'fat' => 15, 'aliases' => ['tapa']],
            ['name' => 'Pork Tocino', 'category' => 'Breakfast', 'serving' => '100 g', 'cal' => 260, 'pro' => 16, 'carb' => 12, 'fat' => 16, 'aliases' => ['tocino']],
            ['name' => 'Champorado', 'category' => 'Breakfast', 'serving' => '1 bowl (~250g)', 'cal' => 220, 'pro' => 4, 'carb' => 42, 'fat' => 4, 'aliases' => []],
            ['name' => 'Arroz Caldo', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 280, 'pro' => 14, 'carb' => 38, 'fat' => 8, 'aliases' => []],
            ['name' => 'Goto', 'category' => 'Soup', 'serving' => '1 bowl (~300g)', 'cal' => 250, 'pro' => 12, 'carb' => 35, 'fat' => 7, 'aliases' => []],
            ['name' => 'Batchoy', 'category' => 'Noodles', 'serving' => '1 bowl (~350g)', 'cal' => 350, 'pro' => 18, 'carb' => 40, 'fat' => 14, 'aliases' => ['la paz batchoy']],
            ['name' => 'Palabok', 'category' => 'Noodles', 'serving' => '1 cup (~250g)', 'cal' => 320, 'pro' => 12, 'carb' => 45, 'fat' => 10, 'aliases' => ['pancit palabok']],
            ['name' => 'Sinangag', 'category' => 'Rice', 'serving' => '1 cup', 'cal' => 250, 'pro' => 4, 'carb' => 40, 'fat' => 8, 'aliases' => ['garlic fried rice']],
            ['name' => 'Plain Rice', 'category' => 'Rice', 'serving' => '1 cup, cooked', 'cal' => 205, 'pro' => 4, 'carb' => 45, 'fat' => 0.4, 'aliases' => ['kanin']],
            ['name' => 'Halo-Halo', 'category' => 'Dessert', 'serving' => '1 serving', 'cal' => 350, 'pro' => 5, 'carb' => 65, 'fat' => 8, 'aliases' => []],
            ['name' => 'Turon', 'category' => 'Dessert', 'serving' => '2 pieces', 'cal' => 220, 'pro' => 2, 'carb' => 38, 'fat' => 8, 'aliases' => []],
            ['name' => 'Puto', 'category' => 'Dessert', 'serving' => '3 pieces', 'cal' => 150, 'pro' => 3, 'carb' => 32, 'fat' => 1, 'aliases' => []],
            ['name' => 'Bibingka', 'category' => 'Dessert', 'serving' => '1 slice', 'cal' => 200, 'pro' => 4, 'carb' => 32, 'fat' => 6, 'aliases' => []],
            ['name' => 'Taho', 'category' => 'Snack', 'serving' => '1 cup', 'cal' => 180, 'pro' => 8, 'carb' => 30, 'fat' => 3, 'aliases' => []],
            ['name' => 'Ensaymada', 'category' => 'Snack', 'serving' => '1 piece', 'cal' => 300, 'pro' => 6, 'carb' => 40, 'fat' => 13, 'aliases' => []],
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
