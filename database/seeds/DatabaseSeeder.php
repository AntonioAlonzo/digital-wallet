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
        // Create the initial balance category
        DB::table('categories')->insert([
            'name' => 'initial balance',
            'type' => 'income',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $currencies = factory(App\Currency::class, 5)->create();
        $walletTypes = factory(App\WalletType::class, 9)->create();
        $categories = factory(App\Category::class, 10)->create();
        $products = factory(App\Product::class, 15)->create();

        // TODO: Refactor
        $users = factory(App\User::class, 5)
            ->create()
            ->each(function ($user) use ($currencies, $walletTypes, $categories, $products) {
                $events = factory(App\Event::class, 2)->create(['user_id' => $user->id]);

                factory(App\Wallet::class, 3)
                    ->create(
                        [
                            'user_id' => $user->id,
                        ]
                    )
                    ->each(function ($wallet) use ($categories, $products,  $currencies) {
                        factory(App\Transaction::class, 3)
                            ->create(
                                [
                                    'wallet_id' => $wallet->id,
                                    'category_id' => $categories[rand(0, 9)]->id,
                                    'currency_id' => $currencies[rand(0, 4)]->id,
                                ]
                            )
                            ->each(function ($transaction) use ($products) {
                                for ($i = 0; $i < 2; $i++) {
                                    $transaction->products()->attach($products[rand(0, 14)]->id);
                                }
                            });
                    });
            });


    }
}
