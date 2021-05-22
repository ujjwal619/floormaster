<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCurrentOrdersChangeInvoiceReceivedType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CURRENT_ORDER, function (Blueprint $table) {
            $table->dropColumn('invoice_received');
            // $table->float('invoice_received')->nullable();
            // $table->date('invoice_received')->nullable();
            $table->float('invoice_received_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CURRENT_ORDER, function (Blueprint $table) {
            $table->dropColumn('invoice_received_amount');
            $table->date('invoice_received')->nullable();
        });
    }
}
