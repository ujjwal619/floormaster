<?php

use App\Constants\DBTable;
use App\Constants\StatusType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::create(
            DBTable::AUTH_USERS,
            function (Blueprint $table) {
                $table->string('id');
                $table->string('username')->unique();
                $table->string('email')->nullable();
                $table->string('password');
                $table->rememberToken();

                $table->text('full_name')->nullable();
                $table->boolean('is_first_login')->default(true);
                $table->string('status')->default(StatusType::UNVERIFIED);
                $table->text('metadata')->nullable();

                $table->string('created_by_id')->index()->nullable();
                $table->string('updated_by_id')->index()->nullable();
                $table->string('deleted_by_id')->index()->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->primary('id');
                $table->foreign('created_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
                $table->foreign('updated_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
                $table->foreign('deleted_by_id')->references('id')->on(DBTable::AUTH_USERS)->onDelete('cascade')->nullable();
            }
        );
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists(DBTable::AUTH_USERS);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
