<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::CONTRACTOR, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->nullable();
            $table->string('name')->nullable();
            $table->string('street')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('key_no')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('vehicle')->nullable();
            $table->string('rego')->nullable();
            $table->string('expires')->nullable();
            $table->string('license')->nullable();
            $table->string('tfn')->unique();
            $table->string('abn')->nullable();
            $table->string('vn')->nullable();
            $table->float('tax')->nullable();
            $table->json('bank')->nullable();
            $table->string('contractor_liability_account')->nullable();
            $table->string('cost_of_sales_account')->nullable();
            $table->json('tax_liability_account')->nullable();
            $table->json('deductions')->nullable();
            $table->json('public_liability_insurance')->nullable();
            $table->json('workers_comp_insurance')->nullable();
            $table->text('note')->nullable();
            $table->boolean('collects_gst')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();

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
        Schema::dropIfExists(DBTable::CONTRACTOR);
    }
}
