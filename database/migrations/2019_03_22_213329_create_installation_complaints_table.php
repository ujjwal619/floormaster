<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallationComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::INSTALLATION_COMPLAINTS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id');
            $table->string('project')->nullable();
            $table->string('received_by')->nullable();
            $table->string('referred_to')->nullable();
            $table->string('sales_person');
            $table->text('complaint')->nullable();
            $table->text('action')->nullable();
            $table->date('date_received')->nullable();
            $table->date('date_rectified')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('cascade');

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::INSTALLATION_COMPLAINTS);
    }
}
