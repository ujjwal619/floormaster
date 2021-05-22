<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFutureStocksAddAndChangeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->string('product_name')->nullable();
            $table->unsignedInteger('variant_id')->nullable()->change();
            $table->dropForeign('tbl_future_stocks_variant_id_foreign');
            $table->dropIndex('tbl_future_stocks_variant_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->dropColumn('product_name');
            $table->unsignedInteger('variant_id')->index()->change();
            $table->foreign('variant_id')->references('id')->on(DBTable::PRODUCT_VARIANTS)->onDelete('cascade');
        });
    }
}
