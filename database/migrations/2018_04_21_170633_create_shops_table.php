<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // later changed to sites coz there is another module name shop
        Schema::create(DBTable::SHOPS, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('gst', 12, 2)->default(config('fms.gst'));
            $table->json('delivery_address')->nullable();
            $table->json('company_details')->nullable();
            $table->json('postal_address')->nullable();
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
