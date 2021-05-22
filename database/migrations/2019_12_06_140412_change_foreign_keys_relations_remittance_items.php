<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeysRelationsRemittanceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->dropForeign('remittance_items_freight_cost_ac_foreign');
            $table->dropForeign('remittance_items_levy_cost_ac_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            //
        });
    }
}
