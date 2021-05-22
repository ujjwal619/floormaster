<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationsAddJobMaterialId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_ALLOCATIONS, function (Blueprint $table) {
            $table->unsignedInteger('job_material_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::STOCK_ALLOCATIONS, function (Blueprint $table) {
            $table->dropColumn('job_material_id');
        });
    }
}
