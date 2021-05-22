<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductCategoriesRemoveUniqueFromName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PRODUCT_CATEGORIES, function (Blueprint $table) {
            $table->dropUnique('tbl_product_categories_name_unique');
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
            $table->unique('name');
        });
    }
}
