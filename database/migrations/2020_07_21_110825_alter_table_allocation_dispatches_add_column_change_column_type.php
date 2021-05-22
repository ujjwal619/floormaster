<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationDispatchesAddColumnChangeColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->string('return_location')->nullable();
            $table->unsignedInteger('job_id')->nullable()->change();
            $table->unsignedInteger('job_material_id')->nullable()->change();
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
            $table->dropColumn('return_location');
        });
    }
}
