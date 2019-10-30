<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->integer('user_profile_id')->unsigned();
            $table->integer('reported_by')->unsigned();
            $table->timestamps();

            $table->foreign('user_profile_id', 'report_users_foreign_user_profile')
                ->references('id')
                ->on('user_profiles')
                ->onDelete('cascade');
            $table->foreign('reported_by', 'report_users_foreign_reported_by')
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
        Schema::table('report_users', function (Blueprint $table) {
            $table->dropForeign('report_users_foreign_user_profile');
            $table->dropForeign('report_users_foreign_reported_by');
        });

        Schema::dropIfExists('report_users');
    }
}
