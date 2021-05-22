<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierPayablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->index();
            $table->unsignedInteger('supplier_id')->index();
            $table->unsignedInteger('liability_account')->nullable();
            $table->unsignedInteger('cost_account')->nullable();
            $table->unsignedInteger('levy_account')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->string('order_no')->nullable();
            $table->string('supplier_reference')->nullable();
            $table->string('client')->nullable();
            $table->date('date_delivered')->nullable();
            $table->date('invoice_date');
            $table->float('invoice_amount');
            $table->float('expected_amount');
            $table->float('goods')->nullable();
            $table->float('freight')->nullable();
            $table->float('levy')->nullable();
            $table->float('gst')->nullable();
            $table->text('comments')->nullable();
            $table->float('adjustment')->nullable();
            $table->json('trading_terms')->nullable();
            $table->json('credit_request')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on(DBTable::SUPPLIERS)->onDelete('cascade');
            $table->foreign('liability_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('cost_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('levy_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action');
            $table->foreign('job_id')->references('id')->on(DBTable::JOBS)->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_payables');
    }
}
