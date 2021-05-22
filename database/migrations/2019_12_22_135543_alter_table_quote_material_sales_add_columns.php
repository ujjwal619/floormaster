<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableQuoteMaterialSalesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->float('gst')->default(0);
            $table->float('levy')->default(0);
            $table->float('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->dropColumn('gst');
            $table->dropColumn('levy');
            $table->dropColumn('discount');
        });
    }
}
