<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContractorsPaymentsDueAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CONTRACTOR_PAYMENT_DUE, function (Blueprint $table) {
            $table->string('client')->nullable();
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
        Schema::table(DBTable::CONTRACTOR_PAYMENT_DUE, function (Blueprint $table) {
            $table->dropColumn('client');
            $table->dropColumn('project');
        });
    }
}
