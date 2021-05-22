<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobMaterialSalesChangeFieldTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->decimal('on_order', 12, 2)->nullable()->change();
            $table->decimal('allocated', 12, 2)->nullable()->change();
            $table->decimal('act_on', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, function (Blueprint $table) {
            $table->float('on_order')->nullable()->change();
            $table->float('allocated')->nullable()->change();
            $table->float('act_on')->nullable()->change();
        });
    }
}
