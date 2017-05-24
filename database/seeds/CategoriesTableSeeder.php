<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'award', 'type' => 'income']);
        Category::create(['name' => 'gifts', 'type' => 'income']);
        Category::create(['name' => 'interest_money', 'type' => 'income']);
        Category::create(['name' => 'scolarship', 'type' => 'income']);
        Category::create(['name' => 'salary', 'type' => 'income']);
        Category::create(['name' => 'selling', 'type' => 'income']);
        Category::create(['name' => 'others', 'type' => 'income']);

        Category::create(['name' => 'bills', 'type' => 'expense']);
        Category::create(['name' => 'education', 'type' => 'expense']);
        Category::create(['name' => 'entertainment', 'type' => 'expense']);
        Category::create(['name' => 'food', 'type' => 'expense']);
        Category::create(['name' => 'health', 'type' => 'expense']);
        Category::create(['name' => 'home_improvement', 'type' => 'expense']);
        Category::create(['name' => 'shopping', 'type' => 'expense']);
        Category::create(['name' => 'telephony', 'type' => 'expense']);
        Category::create(['name' => 'transportation', 'type' => 'expense']);
        Category::create(['name' => 'travel', 'type' => 'expense']);
        Category::create(['name' => 'others', 'type' => 'expense']);

    }
}
