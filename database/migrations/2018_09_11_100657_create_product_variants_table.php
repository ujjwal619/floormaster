<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateVariantProductsTable
 */
class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PRODUCT_VARIANTS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('product_id')->index();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on(DBTable::PRODUCTS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::PRODUCT_VARIANTS);
    }
}
