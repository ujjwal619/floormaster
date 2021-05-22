<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PRODUCTS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('upc')->nullable();
            $table->string('price_base')->nullable();
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('supplier_id')->index();
            $table->float('list_cost')->nullable();
            $table->float('discount')->nullable();
            $table->float('levy')->nullable();
            $table->float('net_cost')->nullable();
            $table->float('gst')->nullable();
            $table->float('width')->nullable();
            $table->string('unit')->nullable();
            $table->json('trade_sell')->nullable();
            $table->json('retail_sell')->nullable();
            $table->json('installed')->nullable();
            $table->boolean('act_on_me')->default(false);
            $table->boolean('exclude_from_report')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on(DBTable::PRODUCT_CATEGORIES)->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PRODUCTS);
    }
}
