<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePivotQuotesMaterialSalesPriceTable
 */
class CreatePivotQuotesMaterialSalesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quote_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('variant_id');
            $table->string('quantity');
            $table->string('unit');
            $table->string('total');

            $table->foreign('quote_id')->references('id')->on(DBTable::QUOTES)->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on(DBTable::PRODUCTS)->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on(DBTable::PRODUCT_VARIANTS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE);
    }
}
