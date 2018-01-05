<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_posts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned();

            /*
             * Add Foreign/Unique/Index
             */
            $table->foreign('user_id', 'foreign_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('post_id', 'foreign_role')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->unique(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save');
    }
}
