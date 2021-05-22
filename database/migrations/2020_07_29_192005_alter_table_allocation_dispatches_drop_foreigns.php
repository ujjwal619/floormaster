<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationDispatchesDropForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocation_dispatches', function (Blueprint $table) {
            $table->dropForeign('allocation_dispatches_job_material_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allocation_dispatches', function (Blueprint $table) {
            $table->foreign('job_material_id')->references('id')->on(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE);
        });
    }
}
