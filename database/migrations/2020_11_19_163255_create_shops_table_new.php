<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // shop (business unit) which recites inside site
        Schema::create(DBTable::SHOPS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('gl_suffix')->nullable();
            $table->string('letterhead_path')->nullable();
            $table->string('street')->nullable();
            $table->string('town')->nullable();
            $table->string('state')->nullable();
            $table->string('code')->nullable();
            $table->unsignedInteger('site_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::SHOPS);
    }
}
