<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTemplatesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::TEMPLATES, function (Blueprint $table) {
            $table->json('customer_details')->nullable();
            $table->json('term')->nullable();
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
            $table->dropColumn('customer_details');
            $table->dropColumn('term');
        });
    }
}
