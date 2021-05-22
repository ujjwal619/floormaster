<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllocationDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation_dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('allocation_id');
            $table->unsignedInteger('job_material_id');
            $table->string('supplier_product_color');
            $table->date('date');
            $table->float('amount');
            $table->float('total')->nullable();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('cascade');
            $table->foreign('allocation_id')->references('id')->on(DBTable::STOCK_ALLOCATIONS);
            $table->foreign('job_material_id')->references('id')->on(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocation_dispatches');
    }
}
