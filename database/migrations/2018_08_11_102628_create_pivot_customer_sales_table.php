<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePivotCustomerSalesTable
 */
class CreatePivotCustomerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_CUSTOMER_SALES, function (Blueprint $table) {
            $table->increments('id');
            $table->string('sales_id');
            $table->unsignedInteger('customer_id');

            $table->foreign('sales_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade');
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
        Schema::dropIfExists(DBTable::PIVOT_CUSTOMER_SALES);
    }
}
