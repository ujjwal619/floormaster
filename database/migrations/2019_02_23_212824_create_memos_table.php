<?php

use App\Constants\DBTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::MEMOS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->text('details')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('user_id');
            $table->unsignedInteger('reference_id');
            $table->string('reference_type');

            $table->boolean('further_action')->default(false);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on(DBTable::AUTH_USERS)
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::MEMOS);
    }
}
