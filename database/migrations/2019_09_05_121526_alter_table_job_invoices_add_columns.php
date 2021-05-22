<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobInvoicesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->float('gst');
            $table->boolean('financed')->default(false);
            $table->date('retention_release_date')->nullable();
            $table->float('retention_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::JOB_INVOICES, function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropColumn('gst');
            $table->dropColumn('financed');
            $table->dropColumn('retention_release_date');
            $table->dropColumn('retention_amount');
        });
    }
}
