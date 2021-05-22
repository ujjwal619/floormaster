<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSitesAddColumnsForQuoteNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::SHOPS, function (Blueprint $table) {
            $table->string('quote_prefix')->nullable();
            $table->bigInteger('quote_number_from')->nullable();
            $table->bigInteger('quote_number_to')->nullable();
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
            $table->dropColumn('quote_prefix');
            $table->dropColumn('quote_number_from');
            $table->dropColumn('quote_number_to');
        });
    }
}
