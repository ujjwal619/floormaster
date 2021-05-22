<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCashBooksAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_books', function (Blueprint $table) {
            $table->unsignedInteger('remit_item_id')->nullable();
            $table->unsignedInteger('receipt_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_books', function (Blueprint $table) {
            $table->dropColumn('remit_item_id');
            $table->dropColumn('receipt_id');
        });
    }
}
