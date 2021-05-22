<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCashBooksRenameRemitItemIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CASH_BOOK, function (Blueprint $table) {
            $table->renameColumn('remit_item_id', 'remit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CASH_BOOK, function (Blueprint $table) {
            $table->renameColumn('remit_id', 'remit_item_id');
        });
    }
}
