<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRemittanceItemsAddPaymentDueIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->unsignedInteger('payment_due_id')->nullable();
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
            $table->dropColumn('payment_due_id');
        });
    }
}
