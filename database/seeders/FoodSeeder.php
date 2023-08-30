<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Food::create([
            'name' => 'Pizza',
            'description' => 'Pizza is a savory dish of Italian origin consisting of a usually round, flattened base of leavened wheat-based dough topped with tomatoes, cheese, and often various other ingredients which is then baked at a high temperature, traditionally in a wood-fired oven.',
            'price' => 10.99,
            'image' => 'https://loremflickr.com/640/480/Pizza',
        ])->create([
            'name' => 'Sushi',
            'description' => 'Sushi is a traditional Japanese dish of prepared vinegared rice, usually with some sugar and salt, accompanying a variety of ingredients, such as seafood, often raw, and vegetables.',
            'price' => 12.99,
            'image' => 'https://loremflickr.com/640/480/Sushi',
        ]);
    }
}
