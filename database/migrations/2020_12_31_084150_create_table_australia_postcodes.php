<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAustraliaPostcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('australia_postcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('postcode');
            $table->string('suburb');
            $table->string('state');
            $table->string('dc');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('australia_postcodes');
    }
}
