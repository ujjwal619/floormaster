<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::JOB_RECEIPT, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id')->index();
            $table->unsignedInteger('invoice_id')->nullable();
            $table->date('receipt_date');
            $table->float('amount');
            $table->string('notation')->nullable();
            $table->string('payment_method');

            $table->timestamps();

            $table->foreign('job_id')
                ->references('id')
                ->on(DBTable::JOBS)->onDelete('cascade');
            $table->foreign('invoice_id')
                ->references('id')
                ->on(DBTable::JOB_INVOICES)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::JOB_RECEIPT);
    }
}
