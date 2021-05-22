<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableJobsAddClientColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::JOBS, function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
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
            $table->dropColumn('phone');
            $table->dropColumn('work_phone');
            $table->dropColumn('mobile');
            $table->dropColumn('email');
            $table->dropColumn('fax');
        });
    }
}
