<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStockMarryInvoicesChangeColumnsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_MARRY_INVOICES, function (Blueprint $table) {
            $table->float('invoice_total')->nullable()->change();
            $table->float('discounted_unit_price')->nullable()->change();
            $table->float('delivery')->nullable()->change();
            $table->float('levy')->nullable()->change();
            $table->float('gst_credit')->nullable()->change();
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
            $table->float('invoice_total')->default(0)->change();
            $table->float('discounted_unit_price')->default(0)->change();
            $table->float('delivery')->default(0)->change();
            $table->float('levy')->default(0)->change();
            $table->float('gst_credit')->default(0)->change();
        });
    }
}
