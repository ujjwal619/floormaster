<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::STOCK_ALLOCATIONS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('variant_id')->index();
            $table->string('client')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->unsignedInteger('current_stock_id');
            $table->date('date_required')->nullable();
            $table->float('amount');
            $table->text('notes')->nullable();
            $table->string('drop_off')->nullable();
            $table->timestamps();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS);
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS);
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS);
            $table->foreign('variant_id')->references('id')->on(DBTable::PRODUCT_VARIANTS)->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('no action');
//            $table->foreign('current_stock_id')->references('id')->on(DBTable::CURRENT_STOCK)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::STOCK_ALLOCATIONS);
    }
}
