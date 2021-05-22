<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableQuoteMaterialSalesChangeFieldsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->float('gst')->nullable()->change();
            $table->float('levy')->nullable()->change();
            $table->float('discount')->nullable()->change();
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
            //
        });
    }
}
