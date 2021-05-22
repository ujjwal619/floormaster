<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFutureStocksAddIsArchivedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->boolean('is_archived')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::FUTURE_STOCK, function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
    }
}
