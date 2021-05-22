<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFutureStockReceiveGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::FUTURE_STOCK_RECEIVE_GROUP, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('future_stock_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::FUTURE_STOCK_RECEIVE_GROUP);
    }
}
