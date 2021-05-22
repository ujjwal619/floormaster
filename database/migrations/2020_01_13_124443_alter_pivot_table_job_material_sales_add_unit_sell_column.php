<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPivotTableJobMaterialSalesAddUnitSellColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->float('unit_sell')->nullable();
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
            $table->dropColumn('unit_sell');
        });
    }
}
