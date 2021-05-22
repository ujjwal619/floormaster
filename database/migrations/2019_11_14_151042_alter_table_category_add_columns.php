<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCategoryAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PRODUCT_CATEGORIES, function (Blueprint $table) {
            $table->unsignedInteger('site_id')->default(1);
            $table->unsignedInteger('inventory_account_id')->nullable();
            $table->unsignedInteger('cos_account_id')->nullable();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
            $table->foreign('inventory_account_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('cos_account_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PRODUCT_CATEGORIES, function (Blueprint $table) {
            $table->dropForeign('tbl_product_categories_site_id_foreign');
            $table->dropForeign('tbl_product_categories_inventory_account_id_foreign');
            $table->dropForeign('tbl_product_categories_cos_account_id_foreign');
            $table->dropColumn('site_id');
            $table->dropColumn('inventory_account_id');
            $table->dropColumn('cos_account_id');
        });
    }
}
