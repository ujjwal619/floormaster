<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('payee');
            $table->date('date');
            $table->date('presented_date')->nullable();
            $table->float('net_amount');
            $table->float('gst_credit')->nullable();
            $table->string('payment_type')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('account_id')->nullable();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('no action');
            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_books');
    }
}
