<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMarryInvoicesChangeCurrentStockIdColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_MARRY_INVOICES, function (Blueprint $table) {
            $table->json('current_stock_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::STOCK_MARRY_INVOICES, function (Blueprint $table) {
            $table->unsignedInteger('current_stock_id')->change();
        });
    }
}
