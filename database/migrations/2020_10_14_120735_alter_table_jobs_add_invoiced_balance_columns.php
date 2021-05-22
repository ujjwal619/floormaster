<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobsAddInvoicedBalanceColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->decimal('invoiced', 12, 2)->nullable();
            $table->decimal('balance', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->dropColumn('invoiced');
            $table->dropColumn('balance');
        });
    }
}
