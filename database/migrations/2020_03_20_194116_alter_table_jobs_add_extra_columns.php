<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobsAddExtraColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->float('costed_commission_paid')->nullable();
            $table->date('costed_commission_date_paid')->nullable();
            $table->float('costed_commission_balance')->nullable();
            $table->text('costed_commission_text')->nullable();
            $table->float('completed_percent')->nullable();
            $table->date('completed_on')->nullable();
            $table->boolean('financed')->default(false);
            $table->date('approved_date')->nullable();
            $table->string('approval_code')->nullable();
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
            $table->dropColumn('costed_commission_paid');
            $table->dropColumn('costed_commission_date_paid');
            $table->dropColumn('costed_commission_balance');
            $table->dropColumn('costed_commission_text');
            $table->dropColumn('completed_percent');
            $table->dropColumn('completed_on');
            $table->dropColumn('financed');
            $table->dropColumn('approved_date');
            $table->dropColumn('approval_code');
        });
    }
}
