<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::CURRENT_STOCK, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('batch')->nullable();
            $table->string('roll_no')->nullable();
            $table->integer('size')->nullable();
            $table->string('location')->nullable();
            $table->string('nb')->nullable();
            $table->string('supplier_inv_no')->nullable();
            $table->double('unit_cost')->nullable();
            $table->double('levy')->nullable();
            $table->double('selling_price')->nullable();
            $table->date('received_date')->nullable();
            $table->date('gl_date')->nullable();
            $table->unsignedInteger('variant_id')->index();

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
        Schema::dropIfExists(DBTable::CURRENT_STOCK);
    }
}
