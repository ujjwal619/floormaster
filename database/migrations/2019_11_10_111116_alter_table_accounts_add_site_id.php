<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAccountsAddSiteId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::ACCOUNT, function (Blueprint $table) {
            $table->unsignedInteger('site_id')->default(1);
            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::ACCOUNT, function (Blueprint $table) {
            $table->dropForeign('tbl_accounts_site_id_foreign');
            $table->dropColumn('site_id');
        });
    }
}
