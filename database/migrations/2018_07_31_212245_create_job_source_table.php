<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateJobSourceTable
 */
class CreateJobSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::JOB_SOURCES, function (Blueprint $table) {
            $table->string('id');
            $table->unsignedInteger('site_id');
            $table->string('title');
            $table->string('name');
            $table->string('created_by_id')->nullable();
            $table->string('updated_by_id')->nullable();
            $table->string('deleted_by_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists(DBTable::JOB_SOURCES);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
