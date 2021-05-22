<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBackOrdersAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
            $table->date('placed')->nullable();
            $table->boolean('is_linked')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::STOCK_BACK_ORDERS, function (Blueprint $table) {
            $table->dropColumn('placed');
            $table->dropColumn('is_linked');
        });
    }
}
