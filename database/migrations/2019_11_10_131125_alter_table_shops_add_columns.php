<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableShopsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::SHOPS, function (Blueprint $table) {
            $table->string('gst_basis')->nullable();
            $table->unsignedInteger('gst_billed_on_sales')->nullable();
            $table->unsignedInteger('gst_on_creditors')->nullable();
            $table->unsignedInteger('trade_creditors')->nullable();
            $table->unsignedInteger('trade_debtors')->nullable();
            $table->unsignedInteger('money_in_trust')->nullable();
            $table->unsignedInteger('job_retention')->nullable();
            $table->unsignedInteger('cheque_account')->nullable();
            $table->unsignedInteger('delivery_bailing')->nullable();
            $table->unsignedInteger('discounts_received')->nullable();
            $table->unsignedInteger('retained_earnings')->nullable();
            $table->unsignedInteger('current_earnings')->nullable();
            $table->foreign('gst_billed_on_sales')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('gst_on_creditors')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('trade_creditors')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('trade_debtors')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('money_in_trust')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('job_retention')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('cheque_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('delivery_bailing')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('discounts_received')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('retained_earnings')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
            $table->foreign('current_earnings')->references('id')->on(DBTable::ACCOUNT)->onDelete('cascade');
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
            $table->dropForeign('shops_gst_billed_on_sales_foreign');
            $table->dropForeign('shops_gst_on_creditors_foreign');
            $table->dropForeign('shops_trade_creditors_foreign');
            $table->dropForeign('shops_trade_debtors_foreign');
            $table->dropForeign('shops_money_in_trust_foreign');
            $table->dropForeign('shops_job_retention_foreign');
            $table->dropForeign('shops_cheque_account_foreign');
            $table->dropForeign('shops_delivery_bailing_foreign');
            $table->dropForeign('shops_discounts_received_foreign');
            $table->dropForeign('shops_retained_earnings_foreign');
            $table->dropForeign('shops_current_earnings_foreign');
            $table->dropColumn('gst_billed_on_sales');
            $table->dropColumn('gst_on_creditors');
            $table->dropColumn('trade_creditors');
            $table->dropColumn('trade_debtors');
            $table->dropColumn('money_in_trust');
            $table->dropColumn('job_retention');
            $table->dropColumn('cheque_account');
            $table->dropColumn('delivery_bailing');
            $table->dropColumn('discounts_received');
            $table->dropColumn('retained_earnings');
            $table->dropColumn('current_earnings');
            $table->dropColumn('gst_basis');
        });
    }
}
