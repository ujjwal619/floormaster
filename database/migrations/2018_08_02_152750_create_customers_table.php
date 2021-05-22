<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCustomersTable
 */
class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::CUSTOMERS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();
            $table->string('trading_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('group_id')->nullable();
            $table->string('attention')->nullable();
            $table->string('mobile')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('email')->nullable();
            $table->json('terms')->nullable();
            $table->string('key_no')->nullable();
            $table->text('notes')->nullable();
            $table->text('postal_address')->nullable();
            $table->text('delivery_address')->nullable();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')->references('id')->on(DBTable::SHOPS)->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists(DBTable::CUSTOMERS);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
