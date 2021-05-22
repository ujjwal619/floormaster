<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePivotQuotesLabourSalesPriceTable
 */
class CreatePivotQuotesLabourSalesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_QUOTES_LABOUR_SALES_PRICE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quote_id');
            $table->unsignedInteger('labour_product_id');
            $table->string('quantity');
            $table->string('unit');
            $table->string('total');

            $table->foreign('quote_id')->references('id')->on(DBTable::QUOTES)->onDelete('cascade');
            $table->foreign('labour_product_id')->references('id')->on(DBTable::LABOUR_PRODUCTS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_QUOTES_LABOUR_SALES_PRICE);
    }
}
