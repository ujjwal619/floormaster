<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateQuotesTable
 */
class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::QUOTES, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->string('project')->nullable();
            $table->text('remarks')->nullable();
            $table->text('quote_id')->nullable();
            $table->text('metadata')->nullable();
            $table->text('commission')->nullable();

            $table->json('labour')->nullable();
            $table->string('job_source_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->boolean('converted_to_job')->default(false);
            $table->string('type')->nullable();
            $table->float('gst_inclusive_quote')->nullable();
            $table->float('gst')->nullable();
            $table->float('calculated_total_sell')->nullable();
            $table->json('term')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
            $table->foreign('job_source_id')->references('id')->on(DBTable::JOB_SOURCES)->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on(DBTable::CUSTOMERS)->onDelete('cascade');

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
        Schema::dropIfExists(DBTable::QUOTES);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
