<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;

class ResturentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Table 1', 'seats' => 2],
            ['name' => 'Table 2', 'seats' => 4],
            ['name' => 'Table 3', 'seats' => 4],
            ['name' => 'Table 4', 'seats' => 6],
            ['name' => 'Patio 1', 'seats' => 2],
            ['name' => 'Patio 2', 'seats' => 4],
        ] as $table) {
            RestaurantTable::firstOrCreate(['name' => $table['name']], $table);
        }

        foreach ([
            ['name' => 'Tomato Soup', 'category' => 'Starter', 'price' => 5.50],
            ['name' => 'Garlic Bread', 'category' => 'Starter', 'price' => 4.00],
            ['name' => 'Grilled Chicken', 'category' => 'Main', 'price' => 14.00],
            ['name' => 'Margherita Pizza', 'category' => 'Main', 'price' => 11.50],
            ['name' => 'Veggie Burger', 'category' => 'Main', 'price' => 10.00],
            ['name' => 'Chocolate Cake', 'category' => 'Dessert', 'price' => 6.00],
            ['name' => 'Iced Tea', 'category' => 'Drink', 'price' => 3.00],
            ['name' => 'Sparkling Water', 'category' => 'Drink', 'price' => 2.50],
        ] as $item) {
            MenuItem::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}
