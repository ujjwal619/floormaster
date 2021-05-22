<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllocationDispatchesAddGlRelatedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->unsignedInteger('transaction_journal_id')->nullable();
            $table->boolean('is_coa_updated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::ALLOCATION_DISPATCH, function (Blueprint $table) {
            $table->dropColumn('transaction_journal_id');
            $table->dropColumn('is_coa_updated');
        });
    }
}
