<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTemplatesAddSalesCodeIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::TEMPLATES, function (Blueprint $table) {
            $table->unsignedInteger('sales_code_id')->nullable();

            $table->foreign('sales_code_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::TEMPLATES, function (Blueprint $table) {
            $table->dropForeign('tbl_templates_sales_code_id_foreign');
            $table->dropColumn('sales_code_id');
        });
    }
}
