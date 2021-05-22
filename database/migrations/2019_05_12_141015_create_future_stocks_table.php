<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFutureStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('quantity')->nullable();
            $table->float('unit')->nullable();
            $table->float('list_price')->nullable();
            $table->float('discount')->nullable();
            $table->float('delivery')->nullable();
            $table->float('tax')->nullable();
            $table->float('sell_price')->nullable();
            $table->float('received')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('placed_with')->nullable();
            $table->unsignedBigInteger('order_number')->index();
            $table->unsignedInteger('variant_id')->index();

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('order_number')->references('id')->on(DBTable::CURRENT_ORDER)->onDelete('cascade');
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
        Schema::dropIfExists(DBTable::FUTURE_STOCK);
    }
}
