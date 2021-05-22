<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStocksAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCKS, function (Blueprint $table) {
            $table->boolean('is_allocation_ongoing')->default(false);
            $table->string('ongoing_allocation_causer')->nullable();
            $table->unsignedInteger('ongoing_allocation_job_material_id')->nullable();
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
            $table->dropColumn('is_allocation_ongoing');
            $table->dropColumn('ongoing_allocation_causer');
            $table->dropColumn('ongoing_allocation_job_material_id');
        });
    }
}
