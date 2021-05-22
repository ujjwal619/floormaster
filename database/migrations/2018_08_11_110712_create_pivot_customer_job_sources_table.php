<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotCustomerJobSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_CUSTOMER_JOB_SOURCE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('job_source_id');
            $table->unsignedInteger('customer_id');

            $table->foreign('job_source_id')->references('id')->on(DBTable::JOB_SOURCES)->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on(DBTable::CUSTOMERS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_CUSTOMER_JOB_SOURCE);
    }
}
