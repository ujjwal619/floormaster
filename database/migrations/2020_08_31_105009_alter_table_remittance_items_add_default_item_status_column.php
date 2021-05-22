<?php

use App\Constants\DBTable;
use App\FMS\Remittance\ValueObjects\DefaultItemStatus;
use App\FMS\Remittance\ValueObjects\RemittanceType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRemittanceItemsAddDefaultItemStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->integer('default_item_status')->default(DefaultItemStatus::PAY);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->dropColumn('default_item_status');
        });
    }
}
