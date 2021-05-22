<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSuppliersTable
 */
class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::SUPPLIERS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->nullable();
            $table->string('trading_name');
            $table->string('street')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('abn')->nullable();
            $table->string('code')->nullable();
            $table->string('contact')->nullable();
            $table->string('suburb')->nullable();
            $table->string('email')->nullable();
            $table->string('state')->nullable();
            $table->json('sales_detail')->nullable();
            $table->json('products')->nullable();
            $table->string('product_list_url')->nullable();
            $table->string('key_no')->nullable();
            $table->json('early_discount')->nullable();
            $table->json('normal_discount')->nullable();
            $table->json('bank')->nullable();
            $table->unsignedInteger('default_cost_account')->nullable();
            $table->unsignedInteger('levy_account')->nullable();
            $table->string('delivery')->nullable();
            $table->unsignedInteger('central_billing')->nullable();
            $table->decimal('levy_percent', 12, 2)->nullable();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();


            $table->foreign('default_cost_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action')->nullable();
            $table->foreign('levy_account')->references('id')->on(DBTable::ACCOUNT)->onDelete('no action')->nullable();
            $table->foreign('central_billing')->references('id')->on(DBTable::SUPPLIERS)->onDelete('no action')->nullable();
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
        Schema::dropIfExists(DBTable::SUPPLIERS);
    }
}
