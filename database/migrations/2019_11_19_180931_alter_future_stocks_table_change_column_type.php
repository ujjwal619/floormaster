<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFutureStocksTableChangeColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Constants\DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->string('unit', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Constants\DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->string('unit', 50)->change();
        });
    }
}
