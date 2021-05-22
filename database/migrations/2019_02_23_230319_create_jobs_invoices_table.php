<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJobsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('amount', 12,2);
            $table->unsignedInteger('job_id')->index();
            $table->unsignedInteger('related_invoice')->nullable();
            $table->timestamps();

            $table->foreign('job_id')
                ->references('id')
                ->on(DBTable::JOBS)
                ->onDelete('cascade');
            $table->foreign('related_invoice')
                ->references('id')
                ->on(DBTable::JOB_INVOICES);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');   
        Schema::dropIfExists(DBTable::JOB_INVOICES);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
