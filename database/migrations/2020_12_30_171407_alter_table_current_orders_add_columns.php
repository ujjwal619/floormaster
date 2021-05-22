<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCurrentOrdersAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::CURRENT_ORDER, function (Blueprint $table) {
            $table->string('client_name')->nullable();
            $table->string('sales_rep')->nullable();
            $table->string('sales_contact')->nullable();
            $table->string('supplier_name')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::CURRENT_ORDER, function (Blueprint $table) {
            $table->dropColumn('client_name');
            $table->dropColumn('sales_rep');
            $table->dropColumn('sales_contact');
            $table->dropColumn('supplier_name');
            $table->dropColumn('supplier_id');
        });
    }
}
