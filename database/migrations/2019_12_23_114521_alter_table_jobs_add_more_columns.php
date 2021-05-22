<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobsAddMoreColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->float('material_total')->default(0);
            $table->float('labour_total')->default(0);
            $table->float('net_cost')->default(0);
            $table->float('costed_commission')->default(0);
            $table->float('quote_price')->default(0);
            $table->float('gst_amount')->default(0);
            $table->float('margin')->default(0);
            $table->float('markup')->default(0);
            $table->float('gp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->dropColumn('material_total');
            $table->dropColumn('labour_total');
            $table->dropColumn('net_cost');
            $table->dropColumn('costed_commission');
            $table->dropColumn('quote_price');
            $table->dropColumn('gst_amount');
            $table->dropColumn('margin');
            $table->dropColumn('markup');
            $table->dropColumn('gp');
        });
    }
}
