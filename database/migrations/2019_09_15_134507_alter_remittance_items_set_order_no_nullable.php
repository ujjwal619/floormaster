<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRemittanceItemsSetOrderNoNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->string('order_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->string('order_no')->change();
        });
    }
}
