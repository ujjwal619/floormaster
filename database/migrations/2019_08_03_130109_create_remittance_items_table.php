<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittanceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::REMITTANCE_ITEMS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('remittance_id');
            $table->string('order_no');
            $table->string('supplier_reference')->nullable();
            $table->decimal('invoice_amount', 12, 2);
            $table->date('invoice_date')->nullable();
            $table->decimal('goods', 12, 2)->nullable();
            $table->decimal('freight', 12, 2)->nullable();
            $table->decimal('levy', 12, 2)->nullable();
            $table->decimal('gst', 12, 2)->nullable();
            $table->unsignedInteger('goods_cost_ac')->nullable();
            $table->unsignedInteger('freight_cost_ac')->nullable();
            $table->unsignedInteger('levy_cost_ac')->nullable();
            $table->decimal('gross_payment', 12, 2)->nullable();
            $table->decimal('adjustment', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('net_payment', 12, 2)->nullable();
            $table->string('comments')->nullable();
            $table->string('job')->nullable();
            $table->timestamps();

            $table->foreign('remittance_id')->references('id')->on(DBTable::REMITTANCE)->onDelete('cascade');
            $table->foreign('goods_cost_ac')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('freight_cost_ac')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('levy_cost_ac')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::REMITTANCE_ITEMS);
    }
}
