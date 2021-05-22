<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePaymentsDueAddGstAmountColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CONTRACTOR_PAYMENT_DUE, function (Blueprint $table) {
            $table->double('gst_amount', 12, 2);
            $table->unsignedInteger('site_id');
            $table->boolean('is_paid')->default(false);
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
            $table->dropColumn('gst_amount');
            $table->dropColumn('site_id');
            $table->dropColumn('is_paid');
        });
    }
}
