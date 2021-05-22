<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactionJournalAddOperatorsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::TRANSACTION_JOURNAL, function (Blueprint $table) {
            $table->string('debit_operator');
            $table->string('credit_operator');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('payable_id')->nullable();
            $table->unsignedInteger('receipt_id')->nullable();
            $table->unsignedInteger('allocation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::TRANSACTION_JOURNAL, function (Blueprint $table) {
            $table->dropColumn('debit_operator');
            $table->dropColumn('credit_operator');
            $table->dropColumn('supplier_id');
            $table->dropColumn('payable_id');
            $table->dropColumn('receipt_id');
            $table->dropColumn('allocation_id');
        });
    }
}
