<?php

use App\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBookingsTable
 */
class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::BOOKINGS, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booking_type_id')->index();
            $table->date('date');
            $table->string('job_id')->nullable();
            $table->string('customer');
            $table->string('location');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->string('for')->nullable();
            $table->time('estimated_time_of_arrival')->nullable();
            $table->time('estimated_time_on_site')->nullable();
            $table->json('numeric_column_headings')->nullable();
            $table->string('text_column_heading')->nullable();

            $table->timestamps();

            $table->string('created_by_id')->index()->nullable();
            $table->string('updated_by_id')->index()->nullable();
            $table->string('deleted_by_id')->index()->nullable();

            $table->foreign('booking_type_id')->references('id')->on(DBTable::BOOKING_TYPES)->onDelete('cascade');

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
        Schema::dropIfExists(DBTable::BOOKINGS);
    }
}
