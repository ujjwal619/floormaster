<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationDispatchesAddMoreColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->float('was');
            $table->float('left');
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
            $table->dropColumn('was');
            $table->dropColumn('left');
        });
    }
}
