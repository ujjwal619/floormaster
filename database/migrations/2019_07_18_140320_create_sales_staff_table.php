<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->string('commission_calculation');
            $table->json('first_tier')->nullable();
            $table->json('second_tier')->nullable();
            $table->json('third_tier')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_staff');
    }
}
