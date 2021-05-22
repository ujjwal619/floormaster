<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTemplatesAddCalculationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::TEMPLATES, function (Blueprint $table) {
            $table->float('costed_commission')->default(0);
            $table->float('quote_price')->default(0);
            $table->float('markup_guide')->default(0);
            $table->float('margin')->default(0);
            $table->float('gp')->default(0);
            $table->float('net_cost')->default(0);
            $table->float('total_cost')->default(0);
            $table->float('material_total')->default(0);
            $table->float('labour_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::TEMPLATES, function (Blueprint $table) {
            $table->dropColumn('costed_commission');
            $table->dropColumn('quote_price');
            $table->dropColumn('markup_guide');
            $table->dropColumn('margin');
            $table->dropColumn('gp');
            $table->dropColumn('net_cost');
            $table->dropColumn('total_cost');
            $table->dropColumn('material_total');
            $table->dropColumn('labour_total');
        });
    }
}
