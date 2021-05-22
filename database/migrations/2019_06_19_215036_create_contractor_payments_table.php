<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::CONTRACTOR_PAYMENT_DUE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contractor_id')->index();
            $table->unsignedInteger('job_id')->index();
            $table->string('details')->nullable();
            $table->float('amount')->nullable();
            $table->float('gst')->nullable();
            $table->date('date')->nullable();
            $table->integer('invoice_no')->nullable();
            $table->timestamps();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();

            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('cascade');
            $table->foreign('contractor_id')->references('id')->on(DBTable::CONTRACTOR)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::CONTRACTOR_PAYMENT_DUE);
    }
}
