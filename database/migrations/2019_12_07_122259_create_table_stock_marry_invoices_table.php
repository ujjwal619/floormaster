<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStockMarryInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::STOCK_MARRY_INVOICES, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('future_stock_id');
            $table->unsignedInteger('current_stock_id');
            $table->unsignedInteger('current_order_id');
            $table->unsignedInteger('site_id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->float('invoice_total')->default(0);
            $table->float('discounted_unit_price')->default(0);
            $table->float('delivery')->default(0);
            $table->float('levy')->default(0);
            $table->float('gst_credit')->default(0);
            $table->integer('quantity');
            $table->timestamps();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::STOCK_MARRY_INVOICES);
    }
}
