<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * IMPORTANT: These are ballpark estimates for typical single-serving orders
 * at major Philippine fastfood chains and convenience stores, compiled for a
 * starter dataset -- they are NOT pulled directly from each brand's official
 * nutrition guide. Several chains (Jollibee, McDonald's PH, KFC PH, Subway
 * PH) do publish official nutrition facts sheets/PDFs on their websites --
 * cross-check against those before this ships to real users tracking their
 * intake, and flip `source` from 'estimated' to the brand's own nutrition
 * guide name once confirmed. Treat this seeder as scaffolding, not a
 * nutrition-accurate dataset.
 *
 * `category` is used here to hold the restaurant/chain name (not dish type),
 * so items can be grouped/filtered by brand in the picker UI.
 */
class RestaurantFoodSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // ================= JOLLIBEE =================
            ['name' => 'Chickenjoy 1pc (No Rice)', 'category' => 'Jollibee', 'serving' => '1 piece (~150g)', 'cal' => 270, 'pro' => 20, 'carb' => 10, 'fat' => 17, 'aliases' => ['chicken joy']],
            ['name' => 'Chickenjoy 1pc w/ Rice', 'category' => 'Jollibee', 'serving' => '1 piece + 1 cup rice', 'cal' => 470, 'pro' => 22, 'carb' => 50, 'fat' => 18, 'aliases' => ['chickenjoy meal']],
            ['name' => 'Chickenjoy 2pc w/ Rice', 'category' => 'Jollibee', 'serving' => '2 pieces + 1 cup rice', 'cal' => 680, 'pro' => 38, 'carb' => 55, 'fat' => 38, 'aliases' => []],
            ['name' => 'Chickenjoy w/ Spaghetti', 'category' => 'Jollibee', 'serving' => '1 piece + spaghetti', 'cal' => 650, 'pro' => 28, 'carb' => 70, 'fat' => 30, 'aliases' => []],
            ['name' => 'Yumburger', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 280, 'pro' => 10, 'carb' => 30, 'fat' => 13, 'aliases' => []],
            ['name' => 'Yumburger w/ Cheese', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 320, 'pro' => 12, 'carb' => 31, 'fat' => 16, 'aliases' => []],
            ['name' => 'Jollibee Champ Burger', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 550, 'pro' => 25, 'carb' => 45, 'fat' => 30, 'aliases' => ['champ']],
            ['name' => 'Bacon Champ', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 620, 'pro' => 28, 'carb' => 46, 'fat' => 36, 'aliases' => []],
            ['name' => 'Amazing Aloha Burger', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 480, 'pro' => 20, 'carb' => 48, 'fat' => 22, 'aliases' => []],
            ['name' => 'Burger Steak w/ Rice', 'category' => 'Jollibee', 'serving' => '1 order', 'cal' => 550, 'pro' => 20, 'carb' => 60, 'fat' => 24, 'aliases' => []],
            ['name' => 'Jolly Hotdog', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 300, 'pro' => 10, 'carb' => 30, 'fat' => 16, 'aliases' => []],
            ['name' => 'Jolly Hotdog Overload', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 380, 'pro' => 14, 'carb' => 32, 'fat' => 22, 'aliases' => []],
            ['name' => 'Jollibee Chicken Sandwich', 'category' => 'Jollibee', 'serving' => '1 sandwich', 'cal' => 400, 'pro' => 22, 'carb' => 38, 'fat' => 18, 'aliases' => []],
            ['name' => 'Palabok Fiesta (Jollibee)', 'category' => 'Jollibee', 'serving' => '1 order (~250g)', 'cal' => 380, 'pro' => 12, 'carb' => 50, 'fat' => 14, 'aliases' => []],
            ['name' => 'Twirls Creamy Mushroom Pasta', 'category' => 'Jollibee', 'serving' => '1 order', 'cal' => 420, 'pro' => 10, 'carb' => 55, 'fat' => 16, 'aliases' => ['twirls pasta']],
            ['name' => 'Jolly Crispy Fries (Regular)', 'category' => 'Jollibee', 'serving' => '1 regular cup', 'cal' => 280, 'pro' => 3, 'carb' => 34, 'fat' => 14, 'aliases' => []],
            ['name' => 'Peach Mango Pie', 'category' => 'Jollibee', 'serving' => '1 piece', 'cal' => 230, 'pro' => 2, 'carb' => 32, 'fat' => 10, 'aliases' => []],
            ['name' => 'Jollibee Halo-Halo', 'category' => 'Jollibee', 'serving' => '1 cup', 'cal' => 300, 'pro' => 4, 'carb' => 55, 'fat' => 8, 'aliases' => []],
            ['name' => 'Coke Float (Regular)', 'category' => 'Jollibee', 'serving' => '1 regular cup', 'cal' => 220, 'pro' => 1, 'carb' => 50, 'fat' => 2, 'aliases' => []],
            ['name' => 'Pineapple Juice (Jollibee)', 'category' => 'Jollibee', 'serving' => '1 cup', 'cal' => 110, 'pro' => 0, 'carb' => 28, 'fat' => 0, 'aliases' => []],

            // ================= MCDONALD'S =================
            ['name' => 'Chicken McDo 1pc w/ Rice', 'category' => "McDonald's", 'serving' => '1 piece + 1 cup rice', 'cal' => 480, 'pro' => 24, 'carb' => 55, 'fat' => 18, 'aliases' => ['mcdo chicken']],
            ['name' => 'Chicken McDo 2pc w/ Rice', 'category' => "McDonald's", 'serving' => '2 pieces + 1 cup rice', 'cal' => 700, 'pro' => 40, 'carb' => 58, 'fat' => 34, 'aliases' => []],
            ['name' => 'Chicken McDo w/ Spaghetti', 'category' => "McDonald's", 'serving' => '1 piece + spaghetti', 'cal' => 650, 'pro' => 28, 'carb' => 70, 'fat' => 28, 'aliases' => []],
            ['name' => 'Big Mac', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 550, 'pro' => 25, 'carb' => 45, 'fat' => 30, 'aliases' => []],
            ['name' => 'Quarter Pounder with Cheese', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 520, 'pro' => 28, 'carb' => 40, 'fat' => 28, 'aliases' => []],
            ['name' => 'Cheeseburger (McDo)', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 300, 'pro' => 15, 'carb' => 30, 'fat' => 13, 'aliases' => []],
            ['name' => 'Double Cheeseburger (McDo)', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 440, 'pro' => 24, 'carb' => 34, 'fat' => 24, 'aliases' => []],
            ['name' => 'McSpaghetti', 'category' => "McDonald's", 'serving' => '1 order', 'cal' => 430, 'pro' => 10, 'carb' => 60, 'fat' => 15, 'aliases' => []],
            ['name' => 'French Fries (Medium, McDo)', 'category' => "McDonald's", 'serving' => '1 medium', 'cal' => 340, 'pro' => 4, 'carb' => 44, 'fat' => 16, 'aliases' => []],
            ['name' => 'French Fries (Large, McDo)', 'category' => "McDonald's", 'serving' => '1 large', 'cal' => 450, 'pro' => 5, 'carb' => 58, 'fat' => 21, 'aliases' => []],
            ['name' => 'McFlurry Oreo', 'category' => "McDonald's", 'serving' => '1 cup', 'cal' => 340, 'pro' => 8, 'carb' => 50, 'fat' => 11, 'aliases' => []],
            ['name' => 'Filet-O-Fish', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 380, 'pro' => 15, 'carb' => 38, 'fat' => 18, 'aliases' => []],
            ['name' => 'McChicken', 'category' => "McDonald's", 'serving' => '1 sandwich', 'cal' => 400, 'pro' => 14, 'carb' => 40, 'fat' => 20, 'aliases' => []],
            ['name' => 'Chicken McNuggets (6pc)', 'category' => "McDonald's", 'serving' => '6 pieces', 'cal' => 280, 'pro' => 14, 'carb' => 18, 'fat' => 17, 'aliases' => ['mcnuggets']],
            ['name' => 'Hotcakes (2pc)', 'category' => "McDonald's", 'serving' => '2 pieces + syrup', 'cal' => 340, 'pro' => 7, 'carb' => 58, 'fat' => 9, 'aliases' => []],
            ['name' => 'Sundae Cone', 'category' => "McDonald's", 'serving' => '1 cone', 'cal' => 150, 'pro' => 3, 'carb' => 22, 'fat' => 5, 'aliases' => []],
            ['name' => 'Apple Pie (McDo)', 'category' => "McDonald's", 'serving' => '1 piece', 'cal' => 230, 'pro' => 2, 'carb' => 32, 'fat' => 11, 'aliases' => []],
            ['name' => 'Corn in a Cup (McDo)', 'category' => "McDonald's", 'serving' => '1 cup', 'cal' => 90, 'pro' => 3, 'carb' => 18, 'fat' => 1, 'aliases' => []],
            ['name' => 'Iced Coffee (Medium, McDo)', 'category' => "McDonald's", 'serving' => '1 medium', 'cal' => 180, 'pro' => 3, 'carb' => 28, 'fat' => 7, 'aliases' => []],

            // ================= KFC =================
            ['name' => 'Original Recipe Chicken 1pc', 'category' => 'KFC', 'serving' => '1 piece (breast)', 'cal' => 390, 'pro' => 30, 'carb' => 12, 'fat' => 25, 'aliases' => []],
            ['name' => 'Hot & Crispy Chicken 1pc', 'category' => 'KFC', 'serving' => '1 piece', 'cal' => 350, 'pro' => 22, 'carb' => 14, 'fat' => 23, 'aliases' => []],
            ['name' => 'KFC Rice', 'category' => 'KFC', 'serving' => '1 cup', 'cal' => 200, 'pro' => 4, 'carb' => 42, 'fat' => 0.5, 'aliases' => []],
            ['name' => 'KFC Coleslaw (Regular)', 'category' => 'KFC', 'serving' => '1 regular cup', 'cal' => 150, 'pro' => 1, 'carb' => 14, 'fat' => 10, 'aliases' => []],
            ['name' => 'Mashed Potato w/ Gravy', 'category' => 'KFC', 'serving' => '1 regular cup', 'cal' => 120, 'pro' => 2, 'carb' => 18, 'fat' => 4, 'aliases' => []],
            ['name' => 'Chicken Popcorn (Regular)', 'category' => 'KFC', 'serving' => '1 regular cup', 'cal' => 380, 'pro' => 18, 'carb' => 24, 'fat' => 24, 'aliases' => []],
            ['name' => 'KFC Egg Tart', 'category' => 'KFC', 'serving' => '1 piece', 'cal' => 200, 'pro' => 4, 'carb' => 20, 'fat' => 11, 'aliases' => []],
            ['name' => 'Zinger Burger', 'category' => 'KFC', 'serving' => '1 sandwich', 'cal' => 500, 'pro' => 22, 'carb' => 45, 'fat' => 26, 'aliases' => []],
            ['name' => 'Chicken Fillet Sandwich (KFC)', 'category' => 'KFC', 'serving' => '1 sandwich', 'cal' => 420, 'pro' => 20, 'carb' => 38, 'fat' => 20, 'aliases' => []],
            ['name' => 'Wicked Wings (4pc)', 'category' => 'KFC', 'serving' => '4 pieces', 'cal' => 320, 'pro' => 20, 'carb' => 8, 'fat' => 22, 'aliases' => []],
            ['name' => 'Krushems (Regular)', 'category' => 'KFC', 'serving' => '1 regular cup', 'cal' => 280, 'pro' => 4, 'carb' => 48, 'fat' => 8, 'aliases' => []],
            ['name' => 'KFC Rice Meal w/ Chicken & Drink', 'category' => 'KFC', 'serving' => '1 combo (1pc chicken)', 'cal' => 590, 'pro' => 26, 'carb' => 56, 'fat' => 25, 'aliases' => []],
            ['name' => 'Egg & Cheese Sandwich (KFC)', 'category' => 'KFC', 'serving' => '1 sandwich', 'cal' => 350, 'pro' => 15, 'carb' => 32, 'fat' => 17, 'aliases' => []],
            ['name' => 'Soy Garlic Wings (4pc)', 'category' => 'KFC', 'serving' => '4 pieces', 'cal' => 340, 'pro' => 20, 'carb' => 12, 'fat' => 23, 'aliases' => []],

            // ================= MANG INASAL =================
            ['name' => 'Chicken Inasal Paa w/ Rice', 'category' => 'Mang Inasal', 'serving' => '1 leg-thigh + rice', 'cal' => 480, 'pro' => 30, 'carb' => 45, 'fat' => 20, 'aliases' => []],
            ['name' => 'Chicken Inasal Pecho w/ Rice', 'category' => 'Mang Inasal', 'serving' => '1 breast + rice', 'cal' => 460, 'pro' => 32, 'carb' => 45, 'fat' => 16, 'aliases' => []],
            ['name' => 'Chicken Inasal Pak (Wing) w/ Rice', 'category' => 'Mang Inasal', 'serving' => '1 wing + rice', 'cal' => 400, 'pro' => 24, 'carb' => 45, 'fat' => 15, 'aliases' => []],
            ['name' => 'Mang Inasal Pork BBQ (1 stick)', 'category' => 'Mang Inasal', 'serving' => '1 stick', 'cal' => 180, 'pro' => 14, 'carb' => 6, 'fat' => 11, 'aliases' => []],
            ['name' => 'Grilled Pork Liempo w/ Rice', 'category' => 'Mang Inasal', 'serving' => '1 order + rice', 'cal' => 520, 'pro' => 24, 'carb' => 45, 'fat' => 28, 'aliases' => []],
            ['name' => 'Isaw (Mang Inasal, 3 sticks)', 'category' => 'Mang Inasal', 'serving' => '3 sticks', 'cal' => 220, 'pro' => 14, 'carb' => 2, 'fat' => 17, 'aliases' => []],
            ['name' => 'Grilled Pusit w/ Rice', 'category' => 'Mang Inasal', 'serving' => '1 order + rice', 'cal' => 380, 'pro' => 22, 'carb' => 40, 'fat' => 13, 'aliases' => []],
            ['name' => 'Sizzling Pork Sisig (Mang Inasal)', 'category' => 'Mang Inasal', 'serving' => '1 order (~200g)', 'cal' => 430, 'pro' => 25, 'carb' => 8, 'fat' => 33, 'aliases' => []],
            ['name' => 'Halo-Halo Overload', 'category' => 'Mang Inasal', 'serving' => '1 serving', 'cal' => 380, 'pro' => 5, 'carb' => 65, 'fat' => 10, 'aliases' => []],
            ['name' => 'Buko Pandan (Mang Inasal)', 'category' => 'Mang Inasal', 'serving' => '1 cup', 'cal' => 220, 'pro' => 3, 'carb' => 34, 'fat' => 8, 'aliases' => []],
            ['name' => 'Unli Rice (1 cup)', 'category' => 'Mang Inasal', 'serving' => '1 cup, cooked', 'cal' => 205, 'pro' => 4, 'carb' => 45, 'fat' => 0.4, 'aliases' => []],

            // ================= CHOWKING =================
            ['name' => 'Chowking Chao Fan (Regular)', 'category' => 'Chowking', 'serving' => '1 regular order', 'cal' => 350, 'pro' => 8, 'carb' => 55, 'fat' => 10, 'aliases' => ['fried rice chowking']],
            ['name' => 'Chicken Ampalaya (Chowking)', 'category' => 'Chowking', 'serving' => '1 order (~200g)', 'cal' => 260, 'pro' => 20, 'carb' => 15, 'fat' => 12, 'aliases' => []],
            ['name' => 'Beef Wonton Mami', 'category' => 'Chowking', 'serving' => '1 bowl (~350g)', 'cal' => 320, 'pro' => 16, 'carb' => 40, 'fat' => 10, 'aliases' => []],
            ['name' => 'Chowking Lauriat Meal', 'category' => 'Chowking', 'serving' => '1 combo meal', 'cal' => 650, 'pro' => 25, 'carb' => 75, 'fat' => 25, 'aliases' => []],
            ['name' => 'Chowking Halo-Halo Special', 'category' => 'Chowking', 'serving' => '1 serving', 'cal' => 350, 'pro' => 4, 'carb' => 65, 'fat' => 8, 'aliases' => []],
            ['name' => 'Chowking Siomai (4pc)', 'category' => 'Chowking', 'serving' => '4 pieces', 'cal' => 220, 'pro' => 10, 'carb' => 18, 'fat' => 12, 'aliases' => []],
            ['name' => 'Sweet & Sour Pork (Chowking)', 'category' => 'Chowking', 'serving' => '1 order (~200g)', 'cal' => 380, 'pro' => 18, 'carb' => 30, 'fat' => 20, 'aliases' => []],
            ['name' => 'Lumpia Shanghai (Chowking, 5pc)', 'category' => 'Chowking', 'serving' => '5 pieces', 'cal' => 240, 'pro' => 9, 'carb' => 18, 'fat' => 14, 'aliases' => []],
            ['name' => 'Yang Chow Fried Rice (Chowking)', 'category' => 'Chowking', 'serving' => '1 regular order', 'cal' => 320, 'pro' => 9, 'carb' => 48, 'fat' => 10, 'aliases' => []],
            ['name' => 'Beef Broccoli (Chowking)', 'category' => 'Chowking', 'serving' => '1 order (~200g)', 'cal' => 260, 'pro' => 20, 'carb' => 12, 'fat' => 14, 'aliases' => []],
            ['name' => 'Chicken Asado Siopao (Chowking)', 'category' => 'Chowking', 'serving' => '1 piece', 'cal' => 300, 'pro' => 12, 'carb' => 44, 'fat' => 8, 'aliases' => []],

            // ================= YELLOW CAB =================
            ["name" => "New York's Finest Pizza (1 slice)", 'category' => 'Yellow Cab', 'serving' => '1 slice, medium', 'cal' => 280, 'pro' => 12, 'carb' => 30, 'fat' => 12, 'aliases' => []],
            ['name' => '4 Cheese Pizza (1 slice)', 'category' => 'Yellow Cab', 'serving' => '1 slice, medium', 'cal' => 300, 'pro' => 13, 'carb' => 28, 'fat' => 15, 'aliases' => []],
            ['name' => 'Garlic Bread Supreme (2pc)', 'category' => 'Yellow Cab', 'serving' => '2 pieces', 'cal' => 220, 'pro' => 5, 'carb' => 26, 'fat' => 10, 'aliases' => []],
            ['name' => 'Buffalo Wings (4pc, Yellow Cab)', 'category' => 'Yellow Cab', 'serving' => '4 pieces', 'cal' => 320, 'pro' => 22, 'carb' => 8, 'fat' => 22, 'aliases' => []],
            ['name' => 'Pasta Carbonara (Yellow Cab)', 'category' => 'Yellow Cab', 'serving' => '1 order', 'cal' => 480, 'pro' => 16, 'carb' => 50, 'fat' => 22, 'aliases' => []],
            ['name' => 'Chicken Lasagna (Yellow Cab)', 'category' => 'Yellow Cab', 'serving' => '1 order', 'cal' => 450, 'pro' => 20, 'carb' => 40, 'fat' => 22, 'aliases' => []],
            ['name' => 'Cowabunga Overload Pizza (1 slice)', 'category' => 'Yellow Cab', 'serving' => '1 slice, medium', 'cal' => 310, 'pro' => 13, 'carb' => 28, 'fat' => 16, 'aliases' => []],
            ['name' => 'NY Cheesecake (1 slice, Yellow Cab)', 'category' => 'Yellow Cab', 'serving' => '1 slice', 'cal' => 350, 'pro' => 6, 'carb' => 32, 'fat' => 22, 'aliases' => []],

            // ================= DOMINO'S =================
            ['name' => 'Hawaiian Pizza (1 slice, Medium)', 'category' => "Domino's", 'serving' => '1 slice, medium', 'cal' => 220, 'pro' => 9, 'carb' => 27, 'fat' => 8, 'aliases' => []],
            ['name' => 'Pepperoni Pizza (1 slice, Medium)', 'category' => "Domino's", 'serving' => '1 slice, medium', 'cal' => 250, 'pro' => 11, 'carb' => 26, 'fat' => 11, 'aliases' => []],
            ["name" => "Domino's Cheesy Garlic Bread (2pc)", 'category' => "Domino's", 'serving' => '2 pieces', 'cal' => 200, 'pro' => 6, 'carb' => 24, 'fat' => 9, 'aliases' => []],
            ["name" => "Domino's Chicken Wings (4pc)", 'category' => "Domino's", 'serving' => '4 pieces', 'cal' => 280, 'pro' => 20, 'carb' => 6, 'fat' => 19, 'aliases' => []],
            ["name" => "Pasta Bolognese (Domino's)", 'category' => "Domino's", 'serving' => '1 order', 'cal' => 450, 'pro' => 18, 'carb' => 55, 'fat' => 15, 'aliases' => []],
            ['name' => 'Meat Lovers Pizza (1 slice, Medium)', 'category' => "Domino's", 'serving' => '1 slice, medium', 'cal' => 290, 'pro' => 13, 'carb' => 26, 'fat' => 16, 'aliases' => []],
            ['name' => 'BBQ Chicken Pizza (1 slice, Medium)', 'category' => "Domino's", 'serving' => '1 slice, medium', 'cal' => 260, 'pro' => 12, 'carb' => 28, 'fat' => 11, 'aliases' => []],
            ["name" => "Choco Lava Cake (Domino's)", 'category' => "Domino's", 'serving' => '1 piece', 'cal' => 320, 'pro' => 4, 'carb' => 40, 'fat' => 16, 'aliases' => []],

            // ================= SUBWAY =================
            ['name' => '6-inch Turkey Breast Sandwich', 'category' => 'Subway', 'serving' => '6-inch, wheat bread', 'cal' => 280, 'pro' => 18, 'carb' => 46, 'fat' => 4, 'aliases' => []],
            ['name' => '6-inch Chicken Teriyaki Sandwich', 'category' => 'Subway', 'serving' => '6-inch, wheat bread', 'cal' => 370, 'pro' => 26, 'carb' => 55, 'fat' => 5, 'aliases' => []],
            ['name' => '6-inch Meatball Marinara Sandwich', 'category' => 'Subway', 'serving' => '6-inch, wheat bread', 'cal' => 480, 'pro' => 21, 'carb' => 50, 'fat' => 20, 'aliases' => []],
            ['name' => 'Footlong Italian BMT', 'category' => 'Subway', 'serving' => 'footlong, wheat bread', 'cal' => 800, 'pro' => 40, 'carb' => 84, 'fat' => 32, 'aliases' => []],
            ['name' => '6-inch Tuna Sandwich', 'category' => 'Subway', 'serving' => '6-inch, wheat bread', 'cal' => 480, 'pro' => 20, 'carb' => 44, 'fat' => 24, 'aliases' => []],
            ['name' => '6-inch Veggie Delite', 'category' => 'Subway', 'serving' => '6-inch, wheat bread', 'cal' => 230, 'pro' => 9, 'carb' => 44, 'fat' => 3, 'aliases' => []],
            ['name' => 'Footlong Turkey Breast', 'category' => 'Subway', 'serving' => 'footlong, wheat bread', 'cal' => 550, 'pro' => 34, 'carb' => 88, 'fat' => 6, 'aliases' => []],
            ['name' => 'Subway Cookie', 'category' => 'Subway', 'serving' => '1 piece', 'cal' => 210, 'pro' => 2, 'carb' => 30, 'fat' => 10, 'aliases' => []],

            // ================= 7-ELEVEN =================
            ['name' => 'Cheesy Bacon Wrap (7-Eleven)', 'category' => '7-Eleven', 'serving' => '1 piece', 'cal' => 380, 'pro' => 12, 'carb' => 30, 'fat' => 22, 'aliases' => []],
            ['name' => 'Siopao Bola-Bola (7-Eleven)', 'category' => '7-Eleven', 'serving' => '1 piece', 'cal' => 320, 'pro' => 12, 'carb' => 42, 'fat' => 10, 'aliases' => []],
            ['name' => 'Big Bite Cheese Hotdog', 'category' => '7-Eleven', 'serving' => '1 piece w/ bun', 'cal' => 280, 'pro' => 10, 'carb' => 20, 'fat' => 18, 'aliases' => ['big bite hotdog']],
            ['name' => 'Slurpee (Regular)', 'category' => '7-Eleven', 'serving' => '1 regular cup', 'cal' => 150, 'pro' => 0, 'carb' => 38, 'fat' => 0, 'aliases' => []],
            ['name' => '7-Eleven Egg Sandwich', 'category' => '7-Eleven', 'serving' => '1 piece', 'cal' => 300, 'pro' => 12, 'carb' => 28, 'fat' => 15, 'aliases' => []],
            ['name' => 'Instant Coffee 3-in-1 (7-Eleven)', 'category' => '7-Eleven', 'serving' => '1 cup', 'cal' => 110, 'pro' => 1, 'carb' => 18, 'fat' => 4, 'aliases' => []],
            ['name' => 'Softdrink in Cup (16oz)', 'category' => '7-Eleven', 'serving' => '16 oz cup', 'cal' => 180, 'pro' => 0, 'carb' => 45, 'fat' => 0, 'aliases' => []],
            ['name' => '7-Select Fried Chicken (1pc)', 'category' => '7-Eleven', 'serving' => '1 piece', 'cal' => 280, 'pro' => 20, 'carb' => 12, 'fat' => 18, 'aliases' => []],
            ['name' => 'Ham & Cheese Sandwich (7-Eleven)', 'category' => '7-Eleven', 'serving' => '1 pack', 'cal' => 320, 'pro' => 14, 'carb' => 30, 'fat' => 16, 'aliases' => []],

            // ================= GREENWICH =================
            ['name' => 'Hawaiian Overload Pizza (1 slice)', 'category' => 'Greenwich', 'serving' => '1 slice, medium', 'cal' => 250, 'pro' => 10, 'carb' => 28, 'fat' => 11, 'aliases' => []],
            ['name' => 'Ultimate Overload Pizza (1 slice)', 'category' => 'Greenwich', 'serving' => '1 slice, medium', 'cal' => 280, 'pro' => 12, 'carb' => 26, 'fat' => 14, 'aliases' => []],
            ['name' => 'Chicken Lasagna (Greenwich)', 'category' => 'Greenwich', 'serving' => '1 order', 'cal' => 420, 'pro' => 18, 'carb' => 38, 'fat' => 20, 'aliases' => []],
            ['name' => 'Overload Meaty Pizza (1 slice)', 'category' => 'Greenwich', 'serving' => '1 slice, medium', 'cal' => 270, 'pro' => 12, 'carb' => 27, 'fat' => 12, 'aliases' => []],

            // ================= SHAKEY'S =================
            ["name" => "Manager's Choice Pizza (1 slice)", 'category' => "Shakey's", 'serving' => '1 slice, medium', 'cal' => 260, 'pro' => 11, 'carb' => 28, 'fat' => 11, 'aliases' => []],
            ["name" => "Bunch of Lunch Chicken (2pc)", 'category' => "Shakey's", 'serving' => '2 pieces', 'cal' => 400, 'pro' => 26, 'carb' => 20, 'fat' => 24, 'aliases' => []],
            ["name" => "Shakey's Mojos (Regular)", 'category' => "Shakey's", 'serving' => '1 regular order', 'cal' => 350, 'pro' => 5, 'carb' => 40, 'fat' => 18, 'aliases' => ['mojos']],
            ["name" => "Shakey's Spaghetti", 'category' => "Shakey's", 'serving' => '1 order', 'cal' => 400, 'pro' => 9, 'carb' => 58, 'fat' => 13, 'aliases' => []],

            // ================= PIZZA HUT =================
            ['name' => 'Super Supreme Pizza (1 slice)', 'category' => 'Pizza Hut', 'serving' => '1 slice, medium', 'cal' => 280, 'pro' => 12, 'carb' => 28, 'fat' => 13, 'aliases' => []],
            ['name' => 'Cheesy Lovers Pizza (1 slice)', 'category' => 'Pizza Hut', 'serving' => '1 slice, medium', 'cal' => 300, 'pro' => 13, 'carb' => 27, 'fat' => 15, 'aliases' => []],
            ['name' => 'Pizza Hut Spaghetti', 'category' => 'Pizza Hut', 'serving' => '1 order', 'cal' => 400, 'pro' => 10, 'carb' => 55, 'fat' => 14, 'aliases' => []],
            ['name' => 'Pan Pizza Classic (1 slice)', 'category' => 'Pizza Hut', 'serving' => '1 slice, medium', 'cal' => 270, 'pro' => 11, 'carb' => 27, 'fat' => 13, 'aliases' => []],

            // ================= ANDOK'S =================
            ["name" => "Andok's Chicken Inasal (1/4)", 'category' => "Andok's", 'serving' => '1/4 chicken', 'cal' => 280, 'pro' => 24, 'carb' => 3, 'fat' => 18, 'aliases' => []],
            ["name" => "Andok's Lechon Manok (1/4)", 'category' => "Andok's", 'serving' => '1/4 chicken', 'cal' => 300, 'pro' => 25, 'carb' => 0, 'fat' => 20, 'aliases' => []],

            // ================= BALIWAG =================
            ['name' => 'Baliwag Lechon Manok (1/4)', 'category' => 'Baliwag', 'serving' => '1/4 chicken', 'cal' => 310, 'pro' => 26, 'carb' => 0, 'fat' => 21, 'aliases' => []],
            ['name' => 'Baliwag Chicken Barbecue (1 stick)', 'category' => 'Baliwag', 'serving' => '1 stick', 'cal' => 200, 'pro' => 14, 'carb' => 6, 'fat' => 13, 'aliases' => []],

            // ================= GOLDILOCKS =================
            ['name' => 'Goldilocks Polvoron', 'category' => 'Goldilocks', 'serving' => '1 piece', 'cal' => 90, 'pro' => 1, 'carb' => 11, 'fat' => 4, 'aliases' => []],
            ['name' => 'Goldilocks Mamon', 'category' => 'Goldilocks', 'serving' => '1 piece', 'cal' => 180, 'pro' => 3, 'carb' => 26, 'fat' => 7, 'aliases' => []],
            ['name' => 'Goldilocks Chicken Sandwich', 'category' => 'Goldilocks', 'serving' => '1 sandwich', 'cal' => 350, 'pro' => 15, 'carb' => 34, 'fat' => 16, 'aliases' => []],
            ['name' => 'Goldilocks Leche Flan', 'category' => 'Goldilocks', 'serving' => '1 slice (~90g)', 'cal' => 230, 'pro' => 5, 'carb' => 32, 'fat' => 9, 'aliases' => []],

            // ================= RED RIBBON =================
            ['name' => 'Red Ribbon Mocha Cake (1 slice)', 'category' => 'Red Ribbon', 'serving' => '1 slice', 'cal' => 380, 'pro' => 4, 'carb' => 50, 'fat' => 18, 'aliases' => []],
            ['name' => 'Red Ribbon Ube Cake (1 slice)', 'category' => 'Red Ribbon', 'serving' => '1 slice', 'cal' => 350, 'pro' => 4, 'carb' => 48, 'fat' => 15, 'aliases' => []],
            ['name' => 'Red Ribbon Sansrival (1 slice)', 'category' => 'Red Ribbon', 'serving' => '1 slice', 'cal' => 400, 'pro' => 5, 'carb' => 32, 'fat' => 28, 'aliases' => []],
            ['name' => 'Red Ribbon Egg Pie (1 slice)', 'category' => 'Red Ribbon', 'serving' => '1 slice', 'cal' => 280, 'pro' => 5, 'carb' => 38, 'fat' => 12, 'aliases' => []],

            // ================= ARMY NAVY =================
            ['name' => 'Army Navy Classic Burger', 'category' => 'Army Navy', 'serving' => '1 sandwich', 'cal' => 450, 'pro' => 22, 'carb' => 35, 'fat' => 24, 'aliases' => []],
            ['name' => 'Army Navy Loaded Fries', 'category' => 'Army Navy', 'serving' => '1 order', 'cal' => 500, 'pro' => 12, 'carb' => 45, 'fat' => 30, 'aliases' => []],
            ['name' => 'Army Navy Nachos', 'category' => 'Army Navy', 'serving' => '1 order (sharing size)', 'cal' => 450, 'pro' => 12, 'carb' => 40, 'fat' => 26, 'aliases' => []],

            // ================= TOKYO TOKYO =================
            ['name' => 'Chicken Teriyaki Bento', 'category' => 'Tokyo Tokyo', 'serving' => '1 bento box', 'cal' => 550, 'pro' => 28, 'carb' => 65, 'fat' => 18, 'aliases' => []],
            ['name' => 'Gyoza (5pc, Tokyo Tokyo)', 'category' => 'Tokyo Tokyo', 'serving' => '5 pieces', 'cal' => 240, 'pro' => 9, 'carb' => 24, 'fat' => 12, 'aliases' => []],
            ['name' => 'Katsu Curry Rice (Tokyo Tokyo)', 'category' => 'Tokyo Tokyo', 'serving' => '1 order', 'cal' => 520, 'pro' => 20, 'carb' => 68, 'fat' => 18, 'aliases' => []],

            // ================= MINUTE BURGER =================
            ['name' => 'Minute Burger Classic', 'category' => 'Minute Burger', 'serving' => '1 sandwich', 'cal' => 250, 'pro' => 10, 'carb' => 25, 'fat' => 12, 'aliases' => []],
            ['name' => 'Minute Burger w/ Egg', 'category' => 'Minute Burger', 'serving' => '1 sandwich', 'cal' => 300, 'pro' => 13, 'carb' => 26, 'fat' => 16, 'aliases' => []],

            // ================= ZARK'S BURGERS =================
            ["name" => "Zark's Angus Burger", 'category' => "Zark's Burgers", 'serving' => '1 sandwich', 'cal' => 550, 'pro' => 28, 'carb' => 40, 'fat' => 30, 'aliases' => []],
            ["name" => "Zark's Chili Cheese Fries", 'category' => "Zark's Burgers", 'serving' => '1 order (sharing size)', 'cal' => 420, 'pro' => 10, 'carb' => 45, 'fat' => 22, 'aliases' => []],

            // ================= POTATO CORNER =================
            ['name' => 'Potato Corner Regular (Barbecue)', 'category' => 'Potato Corner', 'serving' => '1 regular cup', 'cal' => 300, 'pro' => 4, 'carb' => 40, 'fat' => 14, 'aliases' => []],
            ['name' => 'Potato Corner Large (Barbecue)', 'category' => 'Potato Corner', 'serving' => '1 large cup', 'cal' => 420, 'pro' => 6, 'carb' => 55, 'fat' => 20, 'aliases' => []],

            // ================= BURGER KING =================
            ['name' => 'Whopper', 'category' => 'Burger King', 'serving' => '1 sandwich', 'cal' => 660, 'pro' => 28, 'carb' => 49, 'fat' => 40, 'aliases' => []],
            ['name' => 'Chicken Fries (6pc, Burger King)', 'category' => 'Burger King', 'serving' => '6 pieces', 'cal' => 280, 'pro' => 16, 'carb' => 18, 'fat' => 17, 'aliases' => []],
            ['name' => 'BK Fries (Medium)', 'category' => 'Burger King', 'serving' => '1 medium', 'cal' => 340, 'pro' => 4, 'carb' => 45, 'fat' => 16, 'aliases' => []],

            // ================= WENDY'S =================
            ["name" => "Dave's Single Burger", 'category' => "Wendy's", 'serving' => '1 sandwich', 'cal' => 570, 'pro' => 29, 'carb' => 39, 'fat' => 34, 'aliases' => []],
            ["name" => "Wendy's Spicy Chicken Sandwich", 'category' => "Wendy's", 'serving' => '1 sandwich', 'cal' => 510, 'pro' => 28, 'carb' => 50, 'fat' => 20, 'aliases' => []],

            // ================= MAX'S RESTAURANT =================
            ["name" => "Max's Fried Chicken (1pc)", 'category' => "Max's Restaurant", 'serving' => '1 piece', 'cal' => 320, 'pro' => 24, 'carb' => 12, 'fat' => 20, 'aliases' => []],
            ["name" => "Kare-Kareng Bagnet (Max's)", 'category' => "Max's Restaurant", 'serving' => '1 order (~250g)', 'cal' => 480, 'pro' => 22, 'carb' => 18, 'fat' => 36, 'aliases' => []],
            ["name" => "Max's Chicken w/ Rice", 'category' => "Max's Restaurant", 'serving' => '1 piece + rice', 'cal' => 520, 'pro' => 26, 'carb' => 50, 'fat' => 22, 'aliases' => []],

            // ================= KENNY ROGERS ROASTERS =================
            ['name' => '1/4 Roasted Chicken (Kenny Rogers)', 'category' => 'Kenny Rogers Roasters', 'serving' => '1/4 chicken', 'cal' => 320, 'pro' => 30, 'carb' => 2, 'fat' => 20, 'aliases' => []],
            ['name' => 'Creamed Spinach (Kenny Rogers)', 'category' => 'Kenny Rogers Roasters', 'serving' => '1 side order', 'cal' => 150, 'pro' => 4, 'carb' => 10, 'fat' => 10, 'aliases' => []],

            // ================= REYES BARBECUE =================
            ['name' => 'Chicken BBQ w/ Rice (Reyes)', 'category' => 'Reyes Barbecue', 'serving' => '1 stick + rice', 'cal' => 480, 'pro' => 26, 'carb' => 48, 'fat' => 18, 'aliases' => []],
            ['name' => 'Pork BBQ w/ Rice (Reyes)', 'category' => 'Reyes Barbecue', 'serving' => '1 stick + rice', 'cal' => 500, 'pro' => 24, 'carb' => 48, 'fat' => 22, 'aliases' => []],

            // ================= TAPA KING =================
            ['name' => 'Beef Tapa w/ Rice & Egg (Tapa King)', 'category' => 'Tapa King', 'serving' => '1 order', 'cal' => 550, 'pro' => 30, 'carb' => 48, 'fat' => 24, 'aliases' => []],

            // ================= MINISTOP =================
            ['name' => 'Ministop Soft Serve (Regular)', 'category' => 'Ministop', 'serving' => '1 regular cone', 'cal' => 180, 'pro' => 3, 'carb' => 28, 'fat' => 6, 'aliases' => []],
            ['name' => 'Ministop Siomai (4pc)', 'category' => 'Ministop', 'serving' => '4 pieces', 'cal' => 220, 'pro' => 10, 'carb' => 18, 'fat' => 12, 'aliases' => []],
            ['name' => 'Ministop Fried Chicken (1pc)', 'category' => 'Ministop', 'serving' => '1 piece', 'cal' => 300, 'pro' => 20, 'carb' => 12, 'fat' => 18, 'aliases' => []],

            // ================= FAMILYMART =================
            ['name' => 'FamilyMart Onigiri (Tuna Mayo)', 'category' => 'FamilyMart', 'serving' => '1 piece', 'cal' => 180, 'pro' => 5, 'carb' => 32, 'fat' => 4, 'aliases' => []],
            ['name' => 'FamilyMart Sandwich (Ham & Cheese)', 'category' => 'FamilyMart', 'serving' => '1 pack', 'cal' => 320, 'pro' => 14, 'carb' => 30, 'fat' => 16, 'aliases' => []],
            ['name' => 'FamilyMart Chicken Katsu Rice Bowl', 'category' => 'FamilyMart', 'serving' => '1 bowl', 'cal' => 480, 'pro' => 22, 'carb' => 58, 'fat' => 16, 'aliases' => []],

            // ================= ALFAMART =================
            ['name' => 'Alfamart Hotdog Sandwich', 'category' => 'Alfamart', 'serving' => '1 piece', 'cal' => 280, 'pro' => 10, 'carb' => 26, 'fat' => 14, 'aliases' => []],
            ['name' => 'Alfamart Siopao', 'category' => 'Alfamart', 'serving' => '1 piece', 'cal' => 300, 'pro' => 11, 'carb' => 42, 'fat' => 9, 'aliases' => []],

            // ================= LAWSON =================
            ['name' => 'Lawson Onigiri (Chicken)', 'category' => 'Lawson', 'serving' => '1 piece', 'cal' => 190, 'pro' => 6, 'carb' => 32, 'fat' => 4, 'aliases' => []],
            ['name' => 'Lawson Sandwich (Egg)', 'category' => 'Lawson', 'serving' => '1 pack', 'cal' => 280, 'pro' => 10, 'carb' => 28, 'fat' => 13, 'aliases' => []],
        ];

        foreach ($items as $d) {
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
