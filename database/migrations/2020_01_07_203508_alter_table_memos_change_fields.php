<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMemosChangeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::MEMOS, function (Blueprint $table) {
            $table->unsignedInteger('reference_id')->nullable()->change();
            $table->string('reference_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::MEMOS, function (Blueprint $table) {
            $table->unsignedInteger('reference_id')->change();
            $table->string('reference_type')->change();
        });
    }
}
