<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLabourProductsTable
 */
class CreateLabourProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::LABOUR_PRODUCTS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('unit_cost');
            $table->unsignedInteger('category_id');
            $table->boolean('is_featured')->default(false);
            $table->text('metadata')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on(DBTable::PRODUCT_CATEGORIES);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::LABOUR_PRODUCTS);
    }
}
