<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAccountAddAccountBalancColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ACCOUNT, function (Blueprint $table) {
            $table->decimal('account_balance', 12, 2)->nullable();
            $table->decimal('total_balance', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::ACCOUNT, function (Blueprint $table) {
            $table->dropColumn('account_balance');
            $table->dropColumn('total_balance');
        });
    }
}
