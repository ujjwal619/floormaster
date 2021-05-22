<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactionJournalAddFutureStockReceiveGroupIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::TRANSACTION_JOURNAL, function (Blueprint $table) {
            $table->unsignedInteger('future_stock_receive_group_id')->nullable();
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
            $table->dropColumn('future_stock_receive_group_id');
        });
    }
}
