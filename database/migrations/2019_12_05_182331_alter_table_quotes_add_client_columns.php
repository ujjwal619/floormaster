<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableQuotesAddClientColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::QUOTES, function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();
            $table->string('trading_name')->nullable();
            $table->json('address')->nullable();
            $table->string('contact')->nullable();
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
        Schema::table(DBTable::QUOTES, function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('firstname');
            $table->dropColumn('trading_name');
            $table->dropColumn('address');
            $table->dropColumn('contact');
            $table->dropColumn('phone');
            $table->dropColumn('work_phone');
            $table->dropColumn('mobile');
            $table->dropColumn('email');
            $table->dropColumn('fax');
        });
    }
}
