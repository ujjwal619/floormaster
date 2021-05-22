<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSitesAddAutomatedMemosColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::SHOPS, function (Blueprint $table) {
            $table->string('retention_release_user_id')->nullable();
            $table->integer('retention_release_days')->nullable();
            $table->string('customer_complaint_unresolved_user_id')->nullable();
            $table->integer('customer_complaint_unresolved_days')->nullable();
            $table->string('stock_below_reorder_user_id')->nullable();
            $table->string('purchase_orders_overdue_user_id')->nullable();
            $table->string('jobs_invoiced_less_than_quoted_at_complition_user_id')->nullable();
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
            $table->dropColumn('retention_release_user_id');
            $table->dropColumn('retention_release_days');
            $table->dropColumn('customer_complaint_unresolved_user_id');
            $table->dropColumn('customer_complaint_unresolved_days');
            $table->dropColumn('stock_below_reorder_user_id');
            $table->dropColumn('purchase_orders_overdue_user_id');
            $table->dropColumn('jobs_invoiced_less_than_quoted_at_complition_user_id');
        });
    }
}
