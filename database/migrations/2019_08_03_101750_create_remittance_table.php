<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::REMITTANCE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->nullable();
            $table->string('remittance_number');
            $table->integer('remittance_type');
            $table->integer('default_item_status');
            $table->integer('payment_type');
            $table->date('transaction_date')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('payee_name')->nullable();
            $table->string('payee_street')->nullable();
            $table->string('payee_town')->nullable();
            $table->string('payee_state')->nullable();
            $table->string('payee_code')->nullable();
            $table->json('notes')->nullable();

            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS)->onDelete('no action');
            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::REMITTANCE);
    }
}
