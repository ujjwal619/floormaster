<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCKS, function (Blueprint $table) {
            $table->dropColumn('current_stock_allocation_and_back_orders');
            $table->float('total_allocations')->nullable();
            $table->float('total_back_orders')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::STOCKS, function (Blueprint $table) {
            $table->float('current_stock_allocation_and_back_orders')->nullable();
            $table->dropColumn('total_allocations');
            $table->dropColumn('total_back_orders');
        });
    }
}
