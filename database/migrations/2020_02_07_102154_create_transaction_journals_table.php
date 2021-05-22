<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::TRANSACTION_JOURNAL, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_type')->default(1);
            $table->unsignedInteger('site_id');

            $table->unsignedInteger('debit_account_id')->nullable();
            $table->unsignedInteger('credit_account_id')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('cash_book_id')->nullable();
            $table->unsignedInteger('contractor_id')->nullable();
            $table->unsignedInteger('remittance_id')->nullable(); //cheque-butt

            $table->float('debit_amount')->nullable();
            $table->float('credit_amount')->nullable();
            $table->string('name')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('debit_account_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('credit_account_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('no action');
            $table->foreign('invoice_id')->references('id')->on(DBTable::JOB_INVOICES)->onDelete('no action');
            $table->foreign('cash_book_id')->references('id')->on(DBTable::CASH_BOOK)->onDelete('no action');
            $table->foreign('contractor_id')->references('id')->on(DBTable::CONTRACTOR)->onDelete('no action');
            $table->foreign('remittance_id')->references('id')->on(DBTable::REMITTANCE)->onDelete('no action');

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
        Schema::dropIfExists(DBTable::TRANSACTION_JOURNAL);
    }
}
