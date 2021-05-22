<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSitesRenameAccountColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::SHOPS, function (Blueprint $table) {
            $table->renameColumn('gst_billed_on_sales', 'gst_billed_on_sales_id');
            $table->renameColumn('gst_on_creditors', 'gst_on_creditors_id');
            $table->renameColumn('trade_creditors', 'trade_creditors_id');
            $table->renameColumn('trade_debtors', 'trade_debtors_id');
            $table->renameColumn('money_in_trust', 'money_in_trust_id');
            $table->renameColumn('job_retention', 'job_retention_id');
            $table->renameColumn('cheque_account', 'cheque_account_id');
            $table->renameColumn('delivery_bailing', 'delivery_bailing_id');
            $table->renameColumn('discounts_received', 'discounts_received_id');
            $table->renameColumn('retained_earnings', 'retained_earnings_id');
            $table->renameColumn('current_earnings', 'current_earnings_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::SHOPS, function (Blueprint $table) {
            $table->renameColumn('gst_billed_on_sales_id', 'gst_billed_on_sales');
            $table->renameColumn('gst_on_creditors_id', 'gst_on_creditors');
            $table->renameColumn('trade_creditors_id', 'trade_creditors');
            $table->renameColumn('trade_debtors_id', 'trade_debtors');
            $table->renameColumn('money_in_trust_id', 'money_in_trust');
            $table->renameColumn('job_retention_id', 'job_retention');
            $table->renameColumn('cheque_account_id', 'cheque_account');
            $table->renameColumn('delivery_bailing_id', 'delivery_bailing');
            $table->renameColumn('discounts_received_id', 'discounts_received');
            $table->renameColumn('retained_earnings_id', 'retained_earnings');
            $table->renameColumn('current_earnings_id', 'current_earnings');
        });
    }
}
