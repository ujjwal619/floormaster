<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class SalesStaffSupplierTable
 */
class SalesStaffSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PIVOT_SALES_STAFF_SUPPLIER, function (Blueprint $table) {
            $table->increments('id');
            $table->string('sales_id');
            $table->unsignedInteger('supplier_id');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on(DBTable::AUTH_USERS);
            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PIVOT_SALES_STAFF_SUPPLIER);
    }
}
