<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductVariantsAddReorderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PRODUCT_VARIANTS, function (Blueprint $table) {
            $table->float('reorder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PRODUCT_VARIANTS, function (Blueprint $table) {
            $table->dropColumn('reorder');
        });
    }
}
