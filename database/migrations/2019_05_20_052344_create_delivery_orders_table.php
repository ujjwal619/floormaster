<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::DELIVERY_ORDERS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('future_stock_id')->index();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->float('invoice_total')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('discounted_unit_price')->nullable();
            $table->float('delivery')->nullable();
            $table->float('gst_credit')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('future_stock_id')->references('id')->on(DBTable::FUTURE_STOCK)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::DELIVERY_ORDERS);
    }
}
