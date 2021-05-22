<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCurrentStocksChangeFieldTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CURRENT_STOCK, function (Blueprint $table) {
            $table->decimal('sold', 12, 2)->nullable()->change();
            $table->decimal('size', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CURRENT_STOCK, function (Blueprint $table) {
            $table->float('sold')->nullable()->change();
            $table->float('size')->nullable()->change();
        });
    }
}
