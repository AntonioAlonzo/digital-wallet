<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('initial_balance')->default('0.00');
            $table->date('initial_balance_date')->nullable();
            $table->boolean('reportable')->default(false);
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->integer('wallet_type_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
