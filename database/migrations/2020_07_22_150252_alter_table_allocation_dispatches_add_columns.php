<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationDispatchesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->unsignedInteger('variant_id')->nullable();
            $table->unsignedInteger('current_stock_id')->nullable();
            $table->unsignedInteger('site_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->dropColumn('variant_id');
            $table->dropColumn('current_stock_id');
            $table->dropColumn('site_id');
        });
    }
}
