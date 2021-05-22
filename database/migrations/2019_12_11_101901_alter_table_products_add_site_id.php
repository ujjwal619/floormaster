<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductsAddSiteId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PRODUCTS, function (Blueprint $table) {
            $table->unsignedInteger('site_id')->nullable();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PRODUCTS, function (Blueprint $table) {
            $table->dropForeign('tbl_products_site_id_foreign');
            $table->dropColumn('site_id');
        });
    }
}
