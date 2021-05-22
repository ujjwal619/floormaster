<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustomersAddTermIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CUSTOMERS, function (Blueprint $table) {
            $table->unsignedInteger('term_id')->nullable();

            $table->foreign('term_id')->references('id')->on(DBTable::TERMS_AND_CONDITIONS)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CUSTOMERS, function (Blueprint $table) {
            $table->dropForeign('tbl_customers_term_id_foreign');

            $table->dropColumn('term_id');
        });
    }
}
