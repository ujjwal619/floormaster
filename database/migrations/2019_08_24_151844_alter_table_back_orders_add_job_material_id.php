<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBackOrdersAddJobMaterialId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
            $table->unsignedInteger('job_material_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn(DBTable::STOCK_BACK_ORDERS, 'job_material_id'))
        {
            Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
                $table->dropColumn('job_material_id');
            });
        }
    }
}
