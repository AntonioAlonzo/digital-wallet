<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);

        // TODO: Refactor
        $users = factory(App\User::class, 5)
            ->create()
            ->each(function ($user) {
                factory(App\Wallet::class, 3)
                    ->create(
                        [
                            'user_id' => $user->id,
                        ]
                    )
                    ->each(function ($wallet) {
                        factory(App\Transaction::class, 3)
                            ->create(
                                [
                                    'wallet_id' => $wallet->id,
                                    'category_id' => rand(1, 18),
                                    'currency_id' => rand(1, 5),
                                ]
                            );
                    });
            });


    }
}
