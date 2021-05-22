<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePivotQuoteMaterialSalePriceChangeProductIdToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->unsignedInteger('supplier_id');


            $table->unsignedInteger('product_id')->nullable()->change();
            $table->unsignedInteger('variant_id')->nullable()->change();
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
            $table->dropColumn('supplier_id');
        });
    }
}
