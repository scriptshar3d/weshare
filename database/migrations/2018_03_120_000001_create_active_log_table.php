<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_profile_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_profile_id', 'active_logs_foreign_user_profile')
                ->references('id')
                ->on('user_profiles')
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
        Schema::table('active_logs', function (Blueprint $table) {
            $table->dropForeign('active_logs_foreign_user_profile');
        });

        Schema::dropIfExists('active_logs');
    }
}
