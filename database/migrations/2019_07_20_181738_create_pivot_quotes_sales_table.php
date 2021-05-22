<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePivotQuotesSalesTable
 */
class CreatePivotQuotesSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_QUOTES_SALES, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('quote_id');
            $table->string('priority')->default('secondary');
            $table->float('commission')->default(100);

            $table->foreign('sales_id')->references('id')->on(DBTable::SALES_STAFF)->onDelete('cascade');
            $table->foreign('quote_id')->references('id')->on(DBTable::QUOTES)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_QUOTES_SALES);
    }
}
