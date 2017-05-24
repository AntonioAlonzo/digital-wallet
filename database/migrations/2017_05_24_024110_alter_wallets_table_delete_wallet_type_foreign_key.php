<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWalletsTableDeleteWalletTypeForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign(['wallet_type_id']);
            $table->dropColumn('wallet_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->integer('wallet_type_id')->unsigned();
            $table->foreign('wallet_type_id')->references('id')->on('wallet_types')->onDelete('cascade');
        });
    }
}
