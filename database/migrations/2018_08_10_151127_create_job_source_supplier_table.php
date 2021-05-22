<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateJobSourceSupplierTable
 */
class CreateJobSourceSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_JOB_SOURCE_SUPPLIER, function (Blueprint $table) {
            $table->increments('id');
            $table->string('job_source_id');
            $table->unsignedInteger('supplier_id');
            $table->timestamps();

            $table->foreign('job_source_id')->references('id')->on(DBTable::JOB_SOURCES);
            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_JOB_SOURCE_SUPPLIER);
    }
}
