<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblBookingsAddSiteIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::BOOKINGS, function (Blueprint $table) {
            $table->unsignedInteger('site_id')->default(config('fms.defaultSite'));
            $table->string('location')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::BOOKINGS, function (Blueprint $table) {
            $table->dropColumn('site_id');
        });
    }
}
