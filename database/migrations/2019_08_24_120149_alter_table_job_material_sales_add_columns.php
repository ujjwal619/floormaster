<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobMaterialSalesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->integer('on_order')->nullable();
            $table->integer('allocated')->nullable();
            $table->integer('act_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->dropColumn('on_order');
            $table->dropColumn('allocated');
            $table->dropColumn('act_on');
        });
    }
}
