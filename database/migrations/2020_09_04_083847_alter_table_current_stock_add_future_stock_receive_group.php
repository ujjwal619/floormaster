<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCurrentStockAddFutureStockReceiveGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CURRENT_STOCK, function (Blueprint $table) {
            $table->unsignedInteger('future_stock_receive_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CURRENT_STOCK, function (Blueprint $table) {
            $table->dropColumn('future_stock_receive_group_id');
        });
    }
}
