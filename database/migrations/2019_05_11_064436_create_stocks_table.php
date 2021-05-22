<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists(DBTable::STOCKS);

        Schema::create(DBTable::STOCKS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('variant_id')->index();
            $table->text('notes')->nullable();
            $table->float('total_current_stock')->nullable();
            $table->float('current_stock_allocation_and_back_orders')->nullable();
            $table->float('current_stock_total_for_sell')->nullable();
            $table->float('future_stock_total_for_sell')->nullable();
            $table->float('total_future_stock')->nullable();
            $table->float('future_stock_reorder')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('variant_id')->references('id')->on(DBTable::PRODUCT_VARIANTS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::STOCKS);
    }
}
