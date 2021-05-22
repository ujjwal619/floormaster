<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSuppliersPayableAddFutureStockColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::SUPPLIER_PAYABLE, function (Blueprint $table) {
            $table->unsignedInteger('future_stock_id')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::SUPPLIER_PAYABLE, function (Blueprint $table) {
            $table->dropColumn('future_stock_id');
            $table->dropColumn('quantity');
        });
    }
}
