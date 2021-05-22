<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoiceExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index();
            $table->date('debit_date')->nullable();
            $table->unsignedInteger('gl_code')->nullable();
            $table->string('payee')->nullable();
            $table->text('notes')->nullable();
            $table->float('net_amount')->nullable();
            $table->integer('expense_id')->nullable();
            $table->unsignedInteger('site_id');

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
            $table->foreign('gl_code')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('no action')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('no action')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('no action')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_expenses');
    }
}
