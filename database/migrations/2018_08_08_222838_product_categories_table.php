<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Constants\DBTable;

/**
 * Migration for product categories table.
 */
class ProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::PRODUCT_CATEGORIES, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists(DBTable::PRODUCT_CATEGORIES);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
