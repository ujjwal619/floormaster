<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();
            $table->string('trading_name')->nullable();
            $table->json('address')->nullable();
            $table->string('contact')->nullable();
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
            $table->dropColumn('title');
            $table->dropColumn('firstname');
            $table->dropColumn('trading_name');
            $table->dropColumn('address');
            $table->dropColumn('contact');
        });
    }
}
