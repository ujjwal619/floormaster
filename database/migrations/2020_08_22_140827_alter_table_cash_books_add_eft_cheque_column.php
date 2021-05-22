<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCashBooksAddEftChequeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CASH_BOOK, function (Blueprint $table) {
            $table->string('eft_cheque')->nullable();
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
            $table->dropColumn('eft_cheque');
        });
    }
}
