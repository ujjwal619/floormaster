<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateSupplierSitesTable
 */
class CreateSupplierSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::SUPPLIER_SITES, function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name');
            $table->string('gl_suffix')->nullable();
            $table->unsignedInteger('supplier_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::SUPPLIER_SITES);
    }
}
