<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBackOrdersAddProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
            $table->string('project')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
            $table->dropColumn('job_material_id');
        });
    }
}
