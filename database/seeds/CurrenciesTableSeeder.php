<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create(['name' => 'united_states_dollar', 'code' => 'USD']);
        Currency::create(['name' => 'euro', 'code' => 'EUR']);
        Currency::create(['name' => 'japanese_yen', 'code' => 'JPY']);
        Currency::create(['name' => 'canadian_dollar', 'code' => 'CAD']);
        Currency::create(['name' => 'mexican_peso', 'code' => 'MXN']);
    }
}
