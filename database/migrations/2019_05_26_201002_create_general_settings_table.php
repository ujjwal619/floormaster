<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::GENERAL_SETTING, function (Blueprint $table) {
            $table->increments('id');
            $table->string('trading_name')->nullable();
            $table->string('street')->nullable();
            $table->string('town')->nullable();
            $table->string('state')->nullable();
            $table->string('code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('acn')->nullable();
            $table->string('abn')->nullable();
            $table->string('group_id')->nullable();
            $table->json('postal_address')->nullable();
            $table->json('delivery_address')->nullable();

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists(DBTable::GENERAL_SETTING);
    }
}
