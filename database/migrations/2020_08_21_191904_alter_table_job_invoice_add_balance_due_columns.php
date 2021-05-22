<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobInvoiceAddBalanceDueColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->double('balance_due', 12, 2)->nullable();
            $table->double('total_receipts', 12, 2)->nullable();
            $table->double('total_expenses', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->dropColumn('balance_due');
            $table->dropColumn('total_receipts');
            $table->dropColumn('total_expenses');
        });
    }
}
