<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_profile_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('text')->nullable();
            $table->string('media_url')->nullable();
            $table->enum('type', config('constants.enums.post_type'));
            $table->integer('share_count')->default(0);
            $table->string('video_thumbnail_url')->nullable();
            $table->string('text_location_on_video')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
