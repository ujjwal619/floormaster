<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRemittanceAddContractorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::REMITTANCE, function (Blueprint $table) {
            $table->unsignedInteger('contractor_id')->nullable();

            $table->foreign('contractor_id')->references('id')->on(DBTable::CONTRACTOR)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::REMITTANCE, function (Blueprint $table) {
            $table->dropForeign('remittances_contractor_id_foreign');
            $table->dropColumn('contractor_id');
        });
    }
}
