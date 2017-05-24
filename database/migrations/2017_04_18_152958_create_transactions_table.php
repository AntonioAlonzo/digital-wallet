<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 19, 4)->default(0);
            $table->date('transaction_date');
            $table->string('note')->nullable();
            $table->string('location')->nullable();
            $table->date('reminder_date')->nullable();
            $table->boolean('reportable')->default(false);
            $table->timestamps();

            $table->integer('wallet_id')->unsigned();
            $table->integer('category_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
