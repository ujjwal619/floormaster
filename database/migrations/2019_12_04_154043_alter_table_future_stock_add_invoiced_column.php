<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFutureStockAddInvoicedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->integer('invoiced')->default(0);
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
            $table->dropColumn('invoiced');
        });
    }
}
