<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_profile_id')->unsigned();
            $table->integer('requested_by_profile_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_profile_id', 'follow_requests_user_profile_id')
                ->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('requested_by_profile_id', 'follow_requests_requested_by_profile_id')
                ->references('id')->on('user_profiles')->onDelete('cascade');

            $table->unique(['user_profile_id', 'requested_by_profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropForeign('follow_requests_user_profile_id');
            $table->dropForeign('follow_requests_requested_by_profile_id');
        });

        Schema::dropIfExists('follow_requests');
    }
}
