<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobInvoicesAddColumnsAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->float('gst_amount')->nullable();
            $table->float('net_invoice')->nullable();
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
            $table->dropColumn('gst_amount');
            $table->dropColumn('net_invoice');
        });
    }
}
