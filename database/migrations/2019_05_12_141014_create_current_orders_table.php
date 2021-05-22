<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::CURRENT_ORDER, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('supplier_details')->nullable();
            $table->json('delivery_address')->nullable();
            $table->text('interim_order_number')->nullable();
            $table->date('order_date')->default(now());
            $table->string('supplier_reference')->nullable();
            $table->float('costed_price')->nullable();
            $table->date('invoice_received')->nullable();
            $table->date('due_date')->nullable();
            $table->date('last_date_received')->nullable();
            $table->timestamps();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::CURRENT_ORDER);
    }
}
